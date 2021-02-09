<template>
  <b-modal :id="'pay-' + modalId" :ref="'pay-' + modalId" :title="'Pagamentos de ' + type.name" @hidden="resetFiles()">
    <form
      method="POST"
      :action="type.endPoint.replace('despesas', 'pagamentos')"
      enctype="multipart/form-data"
      ref="form">
      <input type="hidden" name="_token" :value="csrf">
      <div
        v-for="(item, index) in payDays"
        class="form-group pt-3 justify-content-center"
      >
        <h5
          class="col-form-label col-lg-6 d-inline"
          >Dia <span class="orange" :class="[hasWarningToday && parseInt(item.due_day) <= parseInt(today) && !savedAsPaid[index] ? 'pulse yellow' : '']" style="font-size: x-large;">{{ item.due_day }}</span> de {{ month }} de {{ year }}
        </h5>

        <div class="page__section orange__custom-settings col-form-label col-lg-6 d-inline"
          :ref="String(item.id) + '-color'"
          :class="{'green__custom-settings': isPaid[index]}">
          <div class="page__toggle d-inline">
            <label class="toggle">
              <input type="checkbox"
                :id="String(item.id) + '-pago'"
                :name="String(item.id) + '-pago'"
                :ref="String(item.id) + '-pago'"
                class="toggle__input"
                @change="togglePay(index)"
                v-model="isPaid[index]">
              <span class="toggle__label">
                <span class="toggle__text">{{ isPaid[index] ? "Pago" : "Não pago" }}</span>
              </span>
            </label>
          </div>
        </div>

        <b-modal :id="'confirm-' + index  + '-' + modalId" :ref="'confirm-' + modalId" title="Confirmar a operação" @hidden="revertPay(index)">
          <h5
            class="m-3"
            >
            Tem certeza de que deseja apagar o pagamento do dia <br>
            <span class="orange" style="font-size: x-large;">{{ item.due_day }}</span> de <span class="orange" style="font-size: x-large;">{{ month }}</span> de <span class="orange" style="font-size: x-large;">{{ year }}</span>?
          </h5>
          <template v-slot:modal-footer>
            <b-button class="btn btn-apagar" @click="hideModal('confirm-' + index  + '-')">
              Cancelar
            </b-button>
            <button
              @click="confirmedDelete(index)"
              class="btn btn-danger">
                Apagar
            </button>
          </template>
        </b-modal>

        <div v-if="hasFile[index]">
          <div class="row d-flex justify-content-center px-0">
            <img
              v-show="item.payments[0].filename.split('.')[item.payments[0].filename.split('.').length - 1] != 'pdf' && isPaid[index]"
              class="col-11 preview-img"
              :src="paymentUrl + item.payments[0].id"
            />

            <embed
              v-show="item.payments[0].filename.split('.')[item.payments[0].filename.split('.').length - 1] == 'pdf' && isPaid[index]"
              height="350"
              class="col-11"
              :src="paymentUrl + item.payments[0].id"
            />
          </div>
        </div>

        <transition name="fade" v-if="!hasFile[index]">
          <div v-show="isPaid[index]">
            <div class="row d-flex justify-content-center px-0">
              <img v-show="hasImage[index]"
                :ref="String(item.id) + '-img'"
                class="col-11 preview-img"
              />

              <embed v-show="hasPDF[index]"
                :ref="String(item.id) + '-embed'"
                height="350"
                class="col-11"
              />
            </div>

            <div class="ml-3">
              <!-- actual upload input, which is hidden -->
              <input type="file"
                :id="String(item.id) + '-actual-btn'"
                :name="String(item.id) + '-actual-btn'"
                :ref="String(item.id) + '-actual-btn'"
                @change="newFile(item, index)"
                accept="image/*,.pdf"
                hidden
              />

              <!-- custom upload button -->
              <label :for="item.id + '-actual-btn'" class="upload-btn bg-green">
                Escolher arquivo
              </label>

              <!-- name of file chosen -->
              <span
                class="file-chosen"
                :ref="String(item.id) + '-file'"
              >
                {{ fileNames[index] }}
              </span>
              
              <a
                class="align-self-center"
                href="#"
                @click.prevent="removeFile(index)"
                v-show="hasImage[index] || hasPDF[index]"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="1.3em"
                  height="1.3em"
                  fill="currentColor"
                  class="bi bi-x"
                  viewBox="0 0 16 16"
                >
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
              </a>
            </div>
          </div>
        </transition>
      </div>
    </form>

    <template v-slot:modal-footer>
      <b-button class="btn btn-apagar" @click="hideModal('pay-')">
        Fechar
      </b-button>
      <button
        @click="pay()"
        class="btn btn-primary">
          Salvar novos pagamentos
      </button>
    </template>
  </b-modal>
</template>

<script>
export default {
  props: {
    month: {
      type: String,
      required: true
    },
    year: {
      type: String,
      required: true
    },
    payDays: {
      type: Array,
      required: true
    },
    type: {
      type: Object,
      required: false
    },
    modalId: {
      type: String,
      required: false
    },
    files: {
      type: String,
      required: false
    },
    paymentUrl: {
      type: String,
      required: true
    },
    hasWarningToday: {
      type: Boolean,
      required: true
    }
  },
  data: function () {
    return {
      fileNames: [],
      hasImage: [],
      hasPDF: [],
      isPaid: [],
      savedAsPaid: [],
      hasFile: [],
      csrf: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
      today: new Date
    }
  },
  methods: {
    newFile(item, index) {
      if (this.payDays != null) {
        var input = this.$refs[this.payDays[index].id + '-actual-btn']
        var image = this.$refs[this.payDays[index].id + '-img']
        var embed = this.$refs[this.payDays[index].id + '-embed']
        if (input[0].files[0] != null) {
          this.$set(this.fileNames, index, input[0].files[0].name)
          if (this.fileNames[index].split('.')[this.fileNames[index].split('.').length - 1] == "pdf") {
            this.$set(this.hasPDF, index, true);
            this.$set(this.hasImage, index, false);
            embed[0].src = window.URL.createObjectURL(input[0].files[0])
            embed[0].style.display = "block"
            image[0].style.display = "none"
          } else {
            this.$set(this.hasPDF, index, false);
            this.$set(this.hasImage, index, true);
            image[0].src = window.URL.createObjectURL(input[0].files[0])
            image[0].style.display = "block"
            embed[0].style.display = "none"
          }
        }
      }
    },
    removeFile(index) {
      if (this.payDays != null) {
        var input = this.$refs[this.payDays[index].id + '-actual-btn']
        var image = this.$refs[this.payDays[index].id + '-img']
        var embed = this.$refs[this.payDays[index].id + '-embed']
        if (input[0].files[0] != null) {
          if (this.fileNames[index].split('.')[this.fileNames[index].split('.').length - 1] == "pdf") {
            this.$set(this.hasPDF, index, false);
            embed[0].src = '#'
            embed[0].style.display = "none"
          } else {
            this.$set(this.hasImage, index, false);
            image[0].src = '#'
            image[0].style.display = "none"
          }
        }
        input[0].value = ""
        this.$set(this.fileNames, index, "Nenhum arquivo selecionado")
      }
    },
    hideModal(type) {
      this.$bvModal.hide(type + this.modalId)
    },
    pay() {
      this.$refs['form'].submit()
    },
    togglePay(index) {
      if (!this.isPaid[index] && this.savedAsPaid[index]) {
        this.$bvModal.show('confirm-' + index  + '-' + this.modalId)
        var checkbox = this.$refs[this.payDays[index].id + '-pago'][0]
        // checkbox.click()
      }
    },
    revertPay(index) {
      // Reverts it only if the payment hasn't been removed
      if (this.payDays[index].payments[0] != null) {
        this.$set(this.isPaid, index, true);
      }
    },
    confirmedDelete(index) {
      try {
        axios.delete(this.paymentUrl + this.payDays[index].payments[0].id);
      } catch (err) {
        // Handle Error Here
        console.error(err);
        this.$eventBus.$emit('flash', "Pagamento não pode ser apagado, atualize a página.", "danger");
      }
      this.$eventBus.$emit('flash', "Pagamento apagado!", "danger");
      this.$bvModal.hide('confirm-' + index  + '-' + this.modalId)

      this.$set(this.fileNames, index, "Nenhum arquivo selecionado");
      this.$set(this.hasImage, index, false);
      this.$set(this.hasPDF, index, false);
      this.$set(this.isPaid, index, false);
      this.$set(this.savedAsPaid, index, false);
      this.$set(this.hasFile, index, false);

      this.payDays[index].payments.splice(0, 1)
    },
    resetFiles() {
      for (var index = 0; index < this.payDays.length; index++) {
        if (!this.hasFile[index]) {
          this.$set(this.fileNames, index, "Nenhum arquivo selecionado");
          this.$set(this.hasImage, index, false);
          this.$set(this.hasPDF, index, false);
          if (!this.savedAsPaid[index]) {
            this.$set(this.isPaid, index, false);
          }
        }
      }
    }
  },
  watch: {
    payDays(ar) {
      for (var i = 0; i < ar.length; i++) {
        this.fileNames[i] = "Nenhum arquivo selecionado"
        this.hasImage[i] = false
        this.hasPDF[i] = false
        if (ar[i].payments != undefined) {
          this.isPaid[i] = (ar[i].payments.length ? true : false)
          this.savedAsPaid[i] = (ar[i].payments.length ? true : false)
          this.hasFile[i] = (ar[i].payments.length && (ar[i].payments[0].filename != null) ? true : false)
        } else {
          this.isPaid[i] = false
          this.savedAsPaid[i] = false
          this.hasFile[i] = false
        }
      }
      this.today = this.today.toLocaleDateString("pt-BR", {
        day: "2-digit"
      })
    }
  }
}
</script>
