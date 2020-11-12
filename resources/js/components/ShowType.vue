<template>
  <div>
      <div class="row d.flex row my-2 justify-content-center">
          <div class="col-md-8">
              <a  :title="type.description"
                  href="#"
                  class="type-title"
                  v-b-modal="modalId()">
                  {{ type.name }}
              </a>

              <b-modal hide-footer :id="modalId()" :title="'Editar ' + type.name" v-cloak>
                  <div>
                      <form method="POST"
                          :action=" type.endPoint"
                          class="cent">
                          <input type="hidden" name="_method" value="PUT">
                          <input type="hidden" name="_token" :value="csrf">

                          <div class="form-group row py-3 justify-content-center">
                              <label for="name" class="col-form-label col-lg-3 offset-lg-1">Nome: </label>
                              <div class="col-lg-7">
                                <input type="string" class="form-control" name="name" required autofocus :value="type.name">
                              </div>
                          </div>
                          <hr>

                          <div class="form-group pt-3 row justify-content-center" v-if="!isIncome">
                              <label for="expense-type" class="col-form-label col-lg-3 offset-lg-1">Tipo: </label>

                              <div class="pl-4 col-lg-7">
                                  <p>
                                      <input type="radio" :id="'fixed-' + type.id" name="expense-type" required value="1" :checked="type.fixed">
                                      <label :for="'fixed-' + type.id">Fixa</label>
                                  </p>
                                  <P>
                                      <input type="radio" :id="'variable-' + type.id" name="expense-type" value="0" :checked="!type.fixed">
                                      <label :for="'variable-' + type.id">Variável</label>
                                  </P>
                              </div>
                          </div>
                          <hr v-if="!isIncome">

                          <div class="form-group row py-3 justify-content-center">
                              <label for="description" class="col-lg-3 offset-lg-1 col-form-label">Descrição: </label>

                              <div class="col-lg-7">
                                  <textarea
                                    name="description"
                                    rows="4"
                                    cols="50"
                                    class="form-control">{{ type.description }}</textarea>
                              </div>
                          </div>

                          <button :id="'editar-' + type.slug" type="submit" class="btn btn-primary btn-sm btn-salvar">
                              Salvar
                          </button>
                      </form>
                  </div>
              </b-modal>
          </div>
          <a class="float-right col-sm-2" href="#" @click.prevent="editing = !editing">
            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
          </a>                                
          <a class="float-right col-sm-2" href="#" @click.prevent="addRecord()">
              <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
              </svg>
          </a>                                
      </div>

    <div v-for="(item, index) in records">
      <a class="float-left" href="#" @click.prevent="deleteRecord(index)" v-if="editing">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
        </svg>
      </a>
      <div class="cent">
          <div class="d.flex row mb-2 justify-content-center">
              <div class="col-md-5 mb-3">
                  <label for="value">Valor</label>
                  <input type="number"
                  name="value"
                  step=".01"
                  class="form-control"
                  onClick="this.select();"
                  @change="updateValue(index)"
                  v-model="item.value">
              </div>
              
              <div class="col-md-7 mb-3">
                  <label for="description" :title="item.description">Observações</label>
                  <input type="text"
                  name="description"
                  class="form-control"
                  @change="updateDescription(index)"
                  v-model="item.description">
              </div>                                 
          </div>
      </div>
    </div>
    <hr>
  </div>
</template>

<script>
  export default {
    props: {
      typeAttrs: {
        type: Object,
        required: true,
      },
      initialRecs: {
        type: Array,
        required: true,
      },
      baseUrl: {
        type: String,
        required: true,
      }
    },
    computed: {
      type: function () {
        return this.typeAttrs
      },
      recs: function () {
        return this.initialRecs
      },
      isIncome: function () {
        return (this.type.fixed === undefined)
      }
    },
    data: function () {
      return {
        csrf: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
        records: null,
        editing: false
      }
    },
    methods: {
      modalId() {
        return 'modal-' + (this.isIncome ? 'receita-' : 'despesa-') + this.type.id
      },
      updateValue(index) {
        axios.put(this.records[index].endPoint, {
            value: this.records[index].value,
            description: this.records[index].description
        }).then(response => {
          this.$eventBus.$emit('flash', "O valor de " + this.type.name + " foi alterado para " + this.records[index].value + ".", "success");
        }).catch(error => {
          this.$eventBus.$emit('flash', "Não foi possível concluir a operação, recarregue a página", "danger");
        });
      },
      updateDescription(index) {
        axios.put(this.records[index].endPoint, {
            value: this.records[index].value,
            description: this.records[index].description
        }).then(response => {
          this.$eventBus.$emit('flash', "A descrição de " + this.type.name + " foi alterada.", "success", "success");
        }).catch(error => {
          this.$eventBus.$emit('flash', "Não foi possível concluir a operação, recarregue a página", "danger");
        });
      },
      addRecord() {
        axios.post(this.type.endPoint)
        .then(response => {
          this.$eventBus.$emit('flash', "Novo registro de " + (this.isIncome ? 'receita' : 'despesa') + " foi criado para " + this.type.name + ".", "success");
          this.makeRecord(response);
        }).catch(error => {
          console.log(error)
          this.$eventBus.$emit('flash', "Não foi possível concluir a operação, recarregue a página", "danger");
        });
      },
      deleteRecord(index) {
        if (this.records.length <= 1) {
            this.$eventBus.$emit('flash', "Não é possível remover o único registro de " + this.type.name + ".", "danger");
        } else {
            axios.delete(this.records[index].endPoint)
            .then(response => {
                this.$eventBus.$emit('flash', "Registro " + this.records[index].description + " de " + this.type.name + " foi removido.", "success");
                this.takeRecord(index)
            }).catch(error => {
              this.$eventBus.$emit('flash', "Não foi possível concluir a operação, recarregue a página", "danger");
            });
        }
      },
      makeRecord(response) {
        this.records.push({
          id: response.data.id,
          value: 0,
          description: null,
          endPoint: this.baseUrl + "/valores/" + response.data.id
        })
      },
      takeRecord(index) {
        this.records.splice(index, 1);
      }
    },
    mounted() {
      this.records = this.recs
    }
  };
</script>