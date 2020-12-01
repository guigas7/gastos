<template>
  <div>
      <div class="row d.flex row my-2 justify-content-center">
          <div class="col-sm-8">
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

                          <div v-for="(item, index) in paydays" class="form-group pt-3 row justify-content-center">
                            <label :for="'due-day' + type.id + '[]'" class="col-form-label col-lg-5 offset-lg-1">{{ index + 1 }}º dia de pagamento: </label>

                            <div class="pl-4 col-lg-4">
                              <input type="number" class="form-control" :name="'due-day' + type.id + '[]'" required autofocus v-model="item.due_day">
                            </div>

                              <a class="align-self-center" href="#" @click.prevent="removeDueDay(index)">
                                <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-x-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                              </a>
                          </div>

                          <div class="form-group float-right mr-4 mb-4">
                              <b-button size="sm" variant="secondary" class="float-right mb-3 btn btn-secondary" @click="addDueDay(key, 0)">
                                Adicionar dia de pagamento
                              </b-button>
                          </div>
                          <hr class="cb">


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
          <a class="float-right col-sm-2" :class="[cColor ? cColor : '']" href="#" @click.prevent="toggleEdit" v-show="!editing">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
          </a>
          <a class="float-right col-sm-2" :class="[cColor ? cColor : '']" href="#" @click.prevent="toggleEdit" v-show="editing">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
            </svg>
          </a>
      </div>

    <div v-if="showing && haveMoreThanOne || !haveMoreThanOne">
      <div v-for="(item, index) in records">
        <div class="cent">
            <div>
              <a class="float-left" href="#" @click.prevent="deleteRecord(index)" v-if="editing && haveMoreThanOne">
                <svg width="1.2em" height="1.5em" viewBox="0 0 16 16" class="bi bi-dash-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg"  :class="[cColor ? cColor : '']">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                </svg>
              </a>
            </div>
            <div class="d.flex row mb-2 justify-content-center">
                <div class="col-md-5 mb-3">
                    <label for="value">Valor</label>
                    <input type="number"
                    name="value"
                    step=".01"
                    class="form-control"
                    :class="[bColor ? bColor : '']"
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
    </div>
    
    <div class="row mx-auto">
      <div class="col-sm-10">
        <span class="type-title col" v-show="haveMoreThanOne">{{ Number(sum).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}) }}</span>
          <a class="float-right col-sm-2" :class="[cColor ? cColor : '']" href="#" @click.prevent="toggleShow" v-show="!showing && haveMoreThanOne">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-caret-down-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M3.544 6.295A.5.5 0 0 1 4 6h8a.5.5 0 0 1 .374.832l-4 4.5a.5.5 0 0 1-.748 0l-4-4.5a.5.5 0 0 1-.082-.537z"/>
              <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
            </svg>
          </a>
          <a class="float-right col-sm-2" :class="[cColor ? cColor : '']" href="#" @click.prevent="toggleShow" v-show="showing">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-caret-up-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4 9a.5.5 0 0 1-.374-.832l4-4.5a.5.5 0 0 1 .748 0l4 4.5A.5.5 0 0 1 12 11H4z"/>
            </svg>
          </a>
      </div>
    <a class="col-sm-2 align-self-end" href="#" @click.prevent="addRecord()" v-if="editing && (showing || !haveMoreThanOne)">
      <svg width="1.3em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg" :class="[cColor ? cColor : '']">
        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
      </svg>
    </a>
    </div>

    <hr>
  </div>
</template>

<script>
  export default {
    props: {
      typeAttrs: {
        type: Object,
        required: true
      },
      initialRecs: {
        type: Array,
        required: true
      },
      baseUrl: {
        type: String,
        required: true
      },
      cColor: {
        type: String,
        required: false
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
      },
      sum: function () {
        if (this.records) {
          return this.records.reduce((acc, curr) => {
            return Number(acc) + Number(curr.value)
          }, 0).toFixed(2);
        } else {
          return 0
        }
      },
      haveMoreThanOne: function () {
        if (this.records && this.records.length > 1) {
          return true
        } else {
          return false
        }
      }
    },
    data: function () {
      return {
        csrf: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
        records: null,
        editing: false,
        showing: false,
        bColor: "b-" + this.cColor,
        paydays: null,
      }
    },
    methods: {
      addDueDay(value) {
        this.paydays.push(value);
      },
      removeDueDay(index) {
          this.paydays.splice(index, 1);
      },
      modalId() {
        return 'modal-' + (this.isIncome ? 'receita-' : 'despesa-') + this.type.id
      },
      toggleEdit() {
        this.editing = !this.editing;
        if (this.haveMoreThanOne && this.editing) this.showing = true;
      },
      toggleShow() {
        this.showing = !this.showing;
        if (!this.showing && this.editing) this.editing = false;
      },
      updateValue(index) {
        if (!this.records[index].value) this.records[index].value = Number(0).toFixed(2);
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
        if (!this.records[index].value) this.records[index].value = Number(0).toFixed(2);
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
                this.takeRecord(index);
            }).catch(error => {
              this.$eventBus.$emit('flash', "Não foi possível concluir a operação, recarregue a página" + error, "danger");
            });
        }
      },
      makeRecord(response) {
        this.records.push({
          id: response.data.id,
          value: Number(0).toFixed(2),
          description: null,
          endPoint: this.baseUrl + "/valores/" + response.data.id
        })
        this.showing = true;
      },
      takeRecord(index) {
        this.records.splice(index, 1);
        if (!this.haveMoreThanOne) this.showing = false;
      }
    },
    mounted() {
      this.records = this.recs
      this.paydays = this.type.paydays
    }
  };
</script>