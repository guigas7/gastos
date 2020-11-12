<template>
    <div class="card-body">
        <div class="cent">
            <ul class="list-group list-group-flush">
                @foreach($incomeTypes as $income)
                    <record
                        :type-attrs="{{ $income }}"
                        :rec-attrs="{{ $income->records->first()}}">
                    </record>
                @endforeach
                <div class="float-right">
				      <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-node-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				        	<path fill-rule="evenodd" d="M11 13a5 5 0 1 0-4.975-5.5H4A1.5 1.5 0 0 0 2.5 6h-1A1.5 1.5 0 0 0 0 7.5v1A1.5 1.5 0 0 0 1.5 10h1A1.5 1.5 0 0 0 4 8.5h2.025A5 5 0 0 0 11 13zm.5-7.5a.5.5 0 0 0-1 0v2h-2a.5.5 0 0 0 0 1h2v2a.5.5 0 0 0 1 0v-2h2a.5.5 0 0 0 0-1h-2v-2z"/>
				      </svg>
			    </div>
            </ul>
        </div>
    </div>
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
    },
    mounted() {
      this.records = this.recs
    }
  };
</script>
