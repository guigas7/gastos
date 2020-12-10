<template>
  <b-tab title="Criar despesas" v-cloak :active="active">
    <b-card-text>
      <b-card no-body>
        <b-tabs card>
          <!-- Render Tabs, supply a unique `key` to each tab -->
          <b-tab v-for="(tab, tindex) in tabs" :key="'exp-tab-' + tab" :title="'Despesa ' + tab">
            <div class="form-group row py-3 justify-content-center">
              <label for="expense-names[]" class="col-form-label col-lg-5 offset-lg-1">Nome da despesa {{ tab }}: </label>
              <div class="col-lg-5">
                <input type="string" class="form-control" name="expense-names[]" v-model="names[tindex]" required>
              </div>
            </div>
            <hr>

            <div class="form-group pt-3 row justify-content-center">
              <label :for="'expense-type' + tab" class="col-form-label col-lg-5 offset-lg-1">Tipo de despesa {{ tab }}: </label>

              <div class="pl-4 col-lg-5">
                <p>
                  <input type="radio" :id="'fixed' + tab" :name="'expense-type' + tab" required value="1" v-model="fixed[tindex]">
                  <label :for="'fixed' + tab">Fixa</label>
                </p>
                <p>
                  <input type="radio" :id="'variable' + tab" :name="'expense-type' + tab" value="0"  v-model="fixed[tindex]">
                  <label :for="'variable' + tab">Variável</label>
                </p>
              </div>
            </div>
            <hr>

            <div v-if="fixed[tindex] == '1'">
              <div v-for="(item, index) in listOfTabs[tindex]" class="form-group pt-3 row justify-content-center">
                <label :for="'due-day' + tab + '[]'" class="col-form-label col-lg-5 offset-lg-1">{{ index + 1 }}º dia de pagamento: </label>

                <div class="pl-4 col-lg-4">
                  <input type="number" class="form-control" :name="'due-day' + tab + '[]'" required autofocus v-model="listOfTabs[tindex][index]">
                </div>

                  <a class="align-self-center" href="#" @click.prevent="removeDueDay(tindex, index)">
                    <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-x-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                      <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                  </a>
              </div>
              
              <div class="form-group float-right mr-4 mb-4">
                  <b-button size="sm" variant="secondary" class="float-right mb-3 btn btn-secondary" @click="addDueDay(tindex, 0)">
                    Adicionar dia de pagamento
                  </b-button>
              </div>
              <hr class="cb">
            </div>

            <div class="form-group row py-3 justify-content-center">
              <label for="expense-descriptions[]" class="col-lg-5 offset-lg-1 col-form-label">Descrição da despesa {{ tab }}: </label>

              <div class="col-lg-5">
                <textarea
                  name="expense-descriptions[]"
                  rows="4"
                  cols="50"
                  class="form-control"
                  v-model="descs[tindex]">
                </textarea>
              </div>
            </div>

            <b-button size="sm" variant="danger" class="float-right mb-3" @click="closeTab(tindex)">
              Remover
            </b-button>
          </b-tab>
          <!-- New Tab Button (Using tabs-end slot) -->
          <template v-slot:tabs-end>
            <b-nav-item role="presentation" @click.prevent="newTab()" href="#"><b>+</b></b-nav-item>
          </template>

          <!-- Render this if no tabs -->
          <template v-slot:empty>
            <div class="text-center text-muted">
              Não há nenhuma despesa a ser criada<br>
              Crie uma despesa nova clicando no botão <b>+</b> acima.
            </div>
          </template>
        </b-tabs>
      </b-card>
    </b-card-text>
    <div v-if="form" class="form-group row float-right">
        <button type="submit" class="btn btn-primary bt">Criar despesas</button>
    </div>
  </b-tab>
</template>

<script>
  export default {
    props: {
      old: {
        type: Object,
        required: false,
      },
      active: {
        type: Boolean,
        required: false,
        default: false,
      },
      form: {
        type: Boolean,
        required: false,
        default: false,
      }
    },
    data() {
      return {
        tabs: [],
        tabCounter: 1,
        fixed: [],
        names: [],
        descs: [],
        listOfTabs: []
      }
    },
    methods: {
      closeTab(key) {
        this.tabs.splice(key, 1);
        this.fixed.splice(key, 1);
        this.names.splice(key, 1);
        this.descs.splice(key, 1);
        this.listOfTabs.splice(key, 1);
      },
      newTab() {
        this.tabs.push(this.tabCounter++);
        this.fixed.push(1);
        this.names.push();
        this.descs.push();
        this.listOfTabs.push(new Array());
      },
      addDueDay(key, value) {
        this.listOfTabs[key].push(value);
      },
      removeDueDay(key, index) {
          this.listOfTabs[key].splice(index, 1);
      },
    },
    computed: {
      hasOld: function () {
        if (this.old) {
          return true;
        } else {
          return false;
        }
      },
    },
    mounted() {
      if (this.hasOld) {
        var expAmnt = this.old['expense-names'].length;
        for (let i = 0; i < expAmnt; i++) {
          this.newTab();
          this.fixed[i] = this.old['expense-type' + (i + 1)];
          this.names[i] = this.old['expense-names'][i];
          this.descs[i] = this.old['expense-descriptions'][i];
          if (this.old.hasOwnProperty('due-day' + (i + 1))) {
            for (let j = 0; j < this.old['due-day' + (i + 1)].length; j++) {
              this.addDueDay(i, this.old['due-day' + (i + 1)][j]);
            }
          }
        }
      }
    }
  }
</script>