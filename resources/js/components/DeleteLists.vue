<template>
    <b-tab :title="'Remover despesas' + (this.hasIncome == true ? ' e receitas' : '')" v-cloak>
        <b-card-text>
            <div class="cent">
                <h4 class="card-header mb-4">Despesas fixas</h4>
                <div v-for="(expense, index) in fixedExpenses">
                    <delete-type
                        :attributes="expense"
                        :index="index">
                    </delete-type>
                </div>
                
                <h4 class="card-header mb-4">Despesas variáveis</h4>
                <div v-for="(expense, index) in variableExpenses">
                    <delete-type
                        :attributes="expense"
                        :index="index">
                    </delete-type>
                </div>

                <div v-if="this.hasIncome">
                    <h4 class="card-header mb-4">Receitas</h4>
                    <div v-for="(income, index) in incomes">
                        <delete-type
                        :attributes="income"
                        :index="index">
                    </delete-type>
                    </div>
                </div>
            </div>
        </b-card-text>
    </b-tab>
</template>

<script>
  export default {
    props: [
      'hasIncome', 'fixedList', 'variableList', 'incomeList'
    ],
    data: function () {
      return {
        fixedExpenses: this.fixedList,
        variableExpenses: this.variableList,
        incomes: this.incomeList,
      }
    },
    methods: {
      removeIncome(index) {
        this.incomes.splice(index, 1)
      },
      removeFixed(index) {
        this.fixedExpenses.splice(index, 1)
      },
      removeVariable(index) {
        this.variableExpenses.splice(index, 1)
      }
    },
    created () {
      this.$eventBus.$on('income_deleted', this.removeIncome)
      this.$eventBus.$on('fixed_deleted', this.removeFixed)
      this.$eventBus.$on('variable_deleted', this.removeVariable)
    }
  };
</script>