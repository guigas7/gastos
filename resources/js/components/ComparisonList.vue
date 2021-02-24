<template>
  <div>

    <b-list-group>
      <b-list-group-item href="#" class="flex-column align-items-start" v-for="(item, index) in comparisonList" v-bind:key="item.id + item.type + item.startMonth + item.startYear">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1 black mr-1">{{ item.name }}</h5>
          <small :class="item.type == 'group' ? 'orange' : 'green'">{{ item.startMonth + '/' + item.startYear }}</small>
        </div>

        <div class="d-flex w-100 justify-content-between">
          <p class="mb-1 mr-1" :class="item.type == 'group' ? 'orange' : 'green'" :title="item.description">
            {{ item.description.substring(0, 30) + '...' }}
          </p>

          <a href="#" class="grey" @click.prevent="removeItem(index)" title="Remover da comparação">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
          </a>
        </div>

      </b-list-group-item>
    </b-list-group>

  </div>
</template>

<script>
  export default {
    props: {
      list: {
        type: Array,
        required: true
      }
    },
    computed: {
      comparisonList: function () {
        return this.list
      }
    },
    data() {
      return {
        selected: null,
      }
    },
    methods: {
      removeItem(index) {
        this.$eventBus.$emit('item_deleted', index);
      }
    }
  };
</script>