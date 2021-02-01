<template>
  <b-modal :id="'pay-' + modalId" :ref="'pay-' + modalId" :title="'Pagamentos de ' + type.name">
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
          >Dia <span class="orange" style="font-size: x-large;">{{ item.due_day }}</span> de {{ month }} de {{ year }}
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
                v-model="isPaid[index]">
              <span class="toggle__label">
                <span class="toggle__text">{{ isPaid[index] ? "Pago" : "Não pago" }}</span>
              </span>
            </label>
          </div>
        </div>

        <div v-if="hasFile[index]">
          <div class="row d-flex justify-content-center px-0">
            <img
              v-show="item.payments[0].filename.split('.')[item.payments[0].filename.split('.').length - 1] != 'pdf'"
              :ref="String(item.id) + '-img-saved'"
              class="col-11 preview-img"
              :src="paymentUrl + item.payments[0].id"
            />

            <embed
              v-show="item.payments[0].filename.split('.')[item.payments[0].filename.split('.').length - 1] == 'pdf'"
              :ref="String(item.id) + '-embed-saved'"
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
                @change="newFile(index)"
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
            </div>
          </div>
        </transition>
      </div>
    </form>

    <template v-slot:modal-footer>
      <b-button class="btn btn-apagar" @click="hideModal()">
        Cancelar
      </b-button>
      <button
        @click="pay()"
        class="btn btn-primary">
          Salvar
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
    }
  },
  data: function () {
    return {
      fileNames: [],
      hasImage: [],
      hasPDF: [],
      isPaid: [],
      hasFile: [],
      csrf: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
    }
  },
  methods: {
    newFile(index) {
      var input = this.$refs[this.payDays[index].id + '-actual-btn']
      var image = this.$refs[this.payDays[index].id + '-img']
      var embed = this.$refs[this.payDays[index].id + '-embed']
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
    },
    hideModal() {
      this.$refs['pay-' + this.modalId].hide()
    },
    pay() {
      this.$refs['form'].submit()
    },
    togglePay(index) {
      div = this.$refs[String(index) + '-color']
    }
  },
  watch: {
    payDays(ar) {
      for (var i = 0; i < ar.length; i++) {
        this.fileNames[i] = "Nenhum arquivo selecionado"
        this.hasImage[i] = false
        this.hasPDF[i] = false
        this.isPaid[i] = (ar[i].payments.length ? true : false)
        // Make an "is checked" like the one above to separate being checked as paid from being saved as paid
        this.hasFile[i] = (ar[i].payments.length && (ar[i].payments[0].filename != null) ? true : false)
        // Cannot set images in here because references aren't setted yet
      }
    }
  }
}
</script>
