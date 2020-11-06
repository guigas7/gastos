<template>
  <div>
    <b-alert
      :show="dismissSecs"
      dismissible
      class= "notification"
      :variant="alertClass"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
    >
      <p>{{ alertMessage }}</p>
      <b-progress
        :variant="alertClass"
        :max="dismissSecs"
        :value="dismissCountDown"
        height="4px"
      ></b-progress>
    </b-alert>
  </div>
</template>

<script>
  export default {
    props: {
      type: {
        type: String,
        default: 'success',
        required: true,
      },
      message: {
        type: String,
        default: 'teste',
        required: true,
      },
    },
    data: function () {
      return {
        alertClass: this.type,
        alertMessage: this.message,
        dismissSecs: 8,
        dismissCountDown: 0,
        showDismissibleAlert: true
      }
    },
    methods: {
      countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      },
      showAlert() {
        this.dismissCountDown = this.dismissSecs
      }
    }
  };
</script>
