<template>
    <div class="table">
        <b-input-group>
            <b-form-input
              size="sm"
              class="my-3"
              v-model="keyword"
              placeholder="Filtrar"
              type="text"
              >
                <template #append>
                    <b-btn
                      :disabled="!keyword"
                      variant="link"
                      size="sm"
                      @click="keyword = ''"
                      aria-label="Close"
                      class="close p-0">
                        x                      
                    </b-btn>
                </template>
            </b-form-input>
        </b-input-group>

        <b-table
          responsive 
          :fields="fields"
          :items="items"
          :keyword="keyword">
            <template #cell(name)="row" :colors="colors">
              <span :style="'font-weight: bold; color: ' + colors[row.item.order]">{{ row.item.name }}</span>
            </template>

            <template #cell(show_details)="row">
              <a @click="row.toggleDetails" :title="row.item.description">
                <svg v-if="!row.detailsShowing" width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-caret-down-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M3.544 6.295A.5.5 0 0 1 4 6h8a.5.5 0 0 1 .374.832l-4 4.5a.5.5 0 0 1-.748 0l-4-4.5a.5.5 0 0 1-.082-.537z"/>
                  <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                </svg>
              </a>
              <a @click="row.toggleDetails" :title="row.item.description">
                <svg v-if="row.detailsShowing" width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-caret-up-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4 9a.5.5 0 0 1-.374-.832l4-4.5a.5.5 0 0 1 .748 0l4 4.5A.5.5 0 0 1 12 11H4z"/>
                </svg>
              </a>
            </template>

            <template #row-details="row">
              <b-card>
                <b-row class="mb-2">
                  <b-col sm="3" class="text-sm-right"><b>Despesas:</b></b-col>
                  <b-col>{{ row.item.expenseString }}</b-col>
                </b-row>
                <a @click="row.toggleDetails" :title="row.item.description">
                  <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-caret-up-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4 9a.5.5 0 0 1-.374-.832l4-4.5a.5.5 0 0 1 .748 0l4 4.5A.5.5 0 0 1 12 11H4z"/>
                  </svg>
                </a>
              </b-card>
            </template>

          <template #custom-foot
          :source="source"
          :attr1="attr1"
          :attr2="attr2">
            <b-tr>
              <b-th><b>Total</b></b-th>
              <b-th><b>{{ source[attr1].toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}) }}</b></b-th>
              <b-th><b>{{ source[attr2].toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}) }}</b></b-th>
              <b-th><b>100.00%</b></b-th>
            </b-tr>
          </template>
        </b-table>
    </div>
</template>

<script>
  export default {
    props: {
      groups: {
        type: Array,
        required: true,
      },
      attr1: {
        type: String,
        required: true,
      },
      attr2: {
        type: String,
        required: true,
      },
      attr3: {
        type: String,
        required: true,
      },
      source: {
        type: Object,
        required: true,
      },
      colors: {
        type: Array,
        required: true,
      }
    },
    data () {
      return {
        keyword: '',
        fields: [
          {key: 'name', label: 'Grupo', sortable: true},
          {key: this.attr1, label: 'Despesa Anual', sortable: true,
            formatter: (value, key, item) => value.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'})},
          {key: this.attr2, label: 'Média p/Mês', sortable: true,
            formatter: (value, key, item) => value.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'})},
          {key: this.attr3, label: '%', sortable: true,
            formatter: (value, key, item) => value.toFixed(2).toString(10) + '%'},
          {key: 'show_details', label: 'Despesas', sortable: false}
        ]
      }
    },
    computed: {
      items () {
        return this.keyword
          ? this.groups.filter(item => item.name.includes(this.keyword))
          : this.groups
      }
    }
  };
</script>