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
            formatter: (value, key, item) => value.toFixed(2).toString(10) + '%'}
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