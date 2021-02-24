<template>
  <div>
    <div class="row justify-content-around my-3 p-0">
      <h2 class="col-12 text-center">Início</h2>
      <div class="mx-auto">
        <select v-model="startMonth" name="month">
          <option v-for="option in months" v-bind:value="option.number">
            {{ option.name }}
          </option>
        </select>
        <select v-model="startYear" name="year">
          <option v-for="option in years" v-bind:value="option">
            {{ option }}
          </option>
        </select>
      </div>
    </div>
    <div class="my-3">
      <h2 class="text-center">Comparar</h2>
      <div class="row form-check justify-content-center text-center">
        <input class="form-check-input" type="radio" name="compare" value="Despesas" id="despesas-radio" v-model="compare">
        <label class="form-check-label" for="despesas-radio">
          Despesas
        </label>
      </div>
      <div class="row form-check justify-content-center text-center">
        <input class="form-check-input" type="radio" name="compare" value="Grupos" id="grupos-radio" v-model="compare">
        <label class="form-check-label" for="grupos-radio">
          Grupos
        </label>
      </div>
    </div>

    <div class="row justify-content-around my-3 p-0">
      <h2 class="col-10 text-center">{{ compare }}</h2>
      <div class="d-flex col-10 mx-0 px-0">
        <input class="flex-grow-1 min-wdpx-100 join-right fill-input" type="text" id="filter" name="filter" v-model="keyword">
        <button class="clear-btn btn btn-info join-left w-inherit d-block clicker" @click="cleanKeyword()">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
          </svg>
        </button>
      </div>
      <select class="fill-select mx-auto col-10 text-center" name="hasExpense" size="6" v-model="selected" @change="updateKeyword()">
        <option v-for="option in items" v-bind:value="option">
          {{ option.name }}
        </option>
      </select>
    </div>
    <div class="mx-3" v-show="selected != null">
      <a href="#" class="float-right mb-3 text-decoration-none" @click="addCompare()">
        <span class="action-text">Adicionar</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
          <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
      </a>
    </div>
    <hr class="cb mt-5 mb-3">
    // adicionar isso em um collapse
    <comparison-list
      :list="comparisonList">
    </comparison-list>
  </div>
</template>

<script>
  export default {
    props: {
      months: {
        type: Array,
        required: true
      },
      years: {
        type: Array,
        required: true
      },
      month: {
        type: Object,
        required: true
      },
      year: {
        type: String,
        required: true
      },
      source: {
        type: Object,
        required: true
      },
    },
    computed: {
      options: function () {
        return this.compare == "Despesas" ? this.source.expenseTypes : this.source.expenseGroups
      },
      items () {
        return this.keyword
          ? this.options.filter(item => item.name.toLowerCase().includes(this.keyword.toLowerCase()))
          : this.options
      }
    },
    data() {
      return {
        startMonth: this.month.number,
        startYear: this.year,
        compare: "Despesas",
        selected: null,
        keyword: '',
        comparisonList: [],
      }
    },
    methods: {
      addCompare() {
        if (this.selected == null || this.selected.name === undefined) {
          return
        }
        this.selected.type = this.selected.fixed === undefined ? 'group' : 'expense'
        if (!this.repeatedItem(this.selected, this.startMonth, this.startYear)) {
          this.comparisonList.push({
            name : this.selected.name,
            id : this.selected.id,
            description : this.selected.description,
            type : this.selected.type,
            startMonth : this.startMonth,
            startYear : this.startYear
          })
        } else {
          this.$eventBus.$emit('flash', "Não é possível inserir um item repetido na comparação", "warning")
        }
        // Reset selector fields
        this.keyword = ''
        this.selected = undefined
        this.startMonth = this.month.number
        this.startYear = this.year
      },
      updateKeyword() {
        if (this.selected == null || this.selected.name === undefined) {
          this.keyword = ''
        } else {
          this.keyword = this.selected.name
        }
      },
      removeItem(index) {
        this.comparisonList.splice(index, 1)
      },
      cleanKeyword() {
        this.keyword = '';
        this.selected = null;
      },
      repeatedItem(selected, month, year) {
        if (this.comparisonList === null || this.comparisonList === undefined) {
          return false
        }
        for (var i = 0; i < this.comparisonList.length; i++) {
          if (selected.name == this.comparisonList[i].name &&
              selected.id == this.comparisonList[i].id &&
              selected.type == this.comparisonList[i].type &&
              month == this.comparisonList[i].startMonth &&
              year == this.comparisonList[i].startYear
          ) {
            return true
          }
        }
        return false
      }
    },
    created () {
      this.$eventBus.$on('item_deleted', this.removeItem)
    }
  };
</script>