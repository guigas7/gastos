<template>
  <b-tab title="Criar receitas" v-cloak>
    <b-card-text>
      <b-card no-body>
        <b-tabs card>
          <!-- Render Tabs, supply a unique `key` to each tab -->
          <b-tab v-for="(tab, tindex) in tabs" :key="'inc-tab-' + tab" :title="'Receita ' + tab">
            <div class="form-group row py-3 justify-content-center">
              <label for="income-names[]" class="col-form-label col-lg-5 offset-lg-1">Nome da receita {{ tab }}: </label>
              <div class="col-lg-5">
                <input type="string" class="form-control" name="income-names[]"  v-model="names[tindex]" required>
              </div>
            </div>
            <hr>

            <div class="form-group row py-3 justify-content-center">
              <label for="income-descriptions[]" class="col-lg-5 offset-lg-1 col-form-label">Descrição da receita {{ tab }}: </label>

              <div class="col-lg-5">
                <textarea
                  name="income-descriptions[]"
                  rows="4"
                  cols="50"
                  class="form-control"
                  v-model="descs[tindex]">
                </textarea>
              </div>
            </div>

            <b-button size="sm" variant="danger" class="float-right mb-3" @click="closeTab(i)">
              Remover
            </b-button>
          </b-tab>
          <!-- New Tab Button (Using tabs-end slot) -->
          <template v-slot:tabs-end>
            <b-nav-item role="presentation" @click.prevent="newTab" href="#"><b>+</b></b-nav-item>
          </template>

          <!-- Render this if no tabs -->
          <template v-slot:empty>
            <div class="text-center text-muted">
              Não há nenhuma receita a ser criada<br>
              Crie uma receita nova clicando no botão <b>+</b> acima.
            </div>
          </template>
        </b-tabs>
      </b-card>
    </b-card-text>
    <div v-if="form" class="form-group row float-right">
        <button type="submit" class="btn btn-primary bt">Criar receitas</button>
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
        names: [],
        descs: [],
      }
    },
    methods: {
      closeTab(key) {
        this.tabs.splice(key, 1);
        this.names.splice(key, 1);
        this.descs.splice(key, 1);
      },
      newTab() {
        this.tabs.push(this.tabCounter++);
        this.names.push();
        this.descs.push();
      }
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
        try {
          var incAmnt = this.old['income-names'].length;
        } catch (err) {
          var incAmnt = 0
          console.log("no income sent though old variable")
        }
        for (let i = 0; i < incAmnt; i++) {
          this.newTab();
          this.names[i] = this.old['income-names'][i];
          this.descs[i] = this.old['income-descriptions'][i];
        }
      }
    }
  }
</script>