<template>
  <div>
    <b-card no-body>
      <b-tabs card>
        <!-- Render Tabs, supply a unique `key` to each tab -->
        <b-tab v-for="i in tabs" :key="'exp-tab-' + i" :title="'Despesa ' + i">
          <div class="form-group row py-3 justify-content-center">
            <label for="expense-names[]" class="col-form-label col-lg-5 offset-lg-1">Nome da despesa {{ i }}: </label>
            <div class="col-lg-5">
              <input type="string" class="form-control" name="expense-names[]" required autofocus>
            </div>
          </div>
          <hr>

          <div class="form-group pt-3 row justify-content-center">
            <label :for="'expense-type' + i" class="col-form-label col-lg-5 offset-lg-1">Tipo de despesa {{ i }}: </label>

            <div class="pl-4 col-lg-5">
              <p>
                <input type="radio" :id="'fixed' + i" :name="'expense-type' + i" required value="1">
                <label :for="'fixed' + i">Fixa</label>
              </p>
              <P>
                <input type="radio" :id="'variable' + i" :name="'expense-type' + i" value="0">
                <label :for="'variable' + i">Variável</label>
              </p>
            </div>
          </div>
          <hr>


          <div class="form-group row py-3 justify-content-center">
            <label for="expense-descriptions[]" class="col-lg-5 offset-lg-1 col-form-label">Descrição da despesa {{ i }}: </label>

            <div class="col-lg-5">
              <textarea
                name="expense-descriptions[]"
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
            Não há nenhuma despesa a ser criada<br>
            Crie uma despesa nova clicando no botão <b>+</b> acima.
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
        tabCounter: 1
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