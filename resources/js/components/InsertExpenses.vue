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
                <input type="radio" :id="'fixed' + i" :name="'expense-type' + i" required value="1"  v-model="fixed">
                <label :for="'fixed' + i">Fixa</label>
              </p>
              <P>
                <input type="radio" :id="'variable' + i" :name="'expense-type' + i" value="0"  v-model="fixed">
                <label :for="'variable' + i">Variável</label>
              </p>
            </div>
          </div>
          <hr>

          <div v-for="(item, index in dueDays" class="form-group pt-3 row justify-content-center">
            <label :for="'due-day' + i + '[]'" class="col-form-label col-lg-5 offset-lg-1">{{ index + 1 }}º dia de pagamento: </label>

            <div class="pl-4 col-lg-4">
              <input type="number" class="form-control" :name="'due-day' + i + '[]'" required autofocus v-model="dueDays[index]">
            </div>

              <a class="align-self-center" href="#" @click.prevent="removeDueDay(index)">
                <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-x-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
              </a>
          </div>
          
          <div class="form-group float-right mr-4 mb-4">
              <b-button size="sm" variant="secondary" class="float-right mb-3 btn btn-secondary" @click="addDueDay(0)">
                Adicionar dia de pagamento
              </b-button>
          </div>
          <hr class="cb">

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
        tabCounter: 1,
        fixed: null,
        dueDaysCounter: 0,
        dueDays: [],
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
      },
      addDueDay(value) {
        this.dueDays.push(value)
      },
      removeDueDay(index) {
          this.dueDays.splice(index, 1)
      },
    }
  }
</script>