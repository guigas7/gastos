<template>
  <div>
    <b-card no-body>
      <b-tabs card>
        <!-- Render Tabs, supply a unique `key` to each tab -->
        <b-tab v-for="i in tabs" :key="'inc-tab-' + i" :title="'Receita ' + i">
          <div class="form-group row py-3 justify-content-center">
            <label for="income-names[]" class="col-form-label col-lg-5 offset-lg-1">Nome da receita {{ i }}: </label>
            <div class="col-lg-5">
              <input type="string" class="form-control" name="income-names[]" required autofocus>
            </div>
          </div>
          <hr>

          <div class="form-group row py-3 justify-content-center">
            <label for="income-descriptions[]" class="col-lg-5 offset-lg-1 col-form-label">Descrição da receita {{ i }}: </label>

            <div class="col-lg-5">
              <textarea
                name="income-descriptions[]"
                rows="4"
                cols="50"
                class="form-control">
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
  </div>
</template>

<script>
  export default {
    data() {
      return {
        tabs: [],
        tabCounter: 1,
      }
    },
    methods: {
      closeTab(x) {
        for (let i = 1; i < this.tabs.length; i++) {
          if (this.tabs[i] === x) {
            this.tabs.splice(i, 1)
          }
        }
      },
      newTab() {
        this.tabs.push(this.tabCounter++)
      }
    }
  }
</script>