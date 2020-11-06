<template>
<!-- 
  <flash-message v-for="message as messages" :type="type" message="{{ Session::get('success') }}"></flash-message>
 -->
    <b-alert
      :show="dismissCountDown"
      dismissible
      :variant="type"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
    >
      <p>{{ body }}</p>
      <b-progress
        :variant="type"
        :max="dismissSecs"
        :value="dismissCountDown"
        height="4px"
      ></b-progress>
    </b-alert>
</template>

<script>
  export default {
    props: {
      message: {
        type: String,
      }
    },
    data() {
      return {
        body: '',
        type: 'success',
        show: false,
        dismissSecs: 5,
        dismissCountDown: 0,
        messages: null
      }
    },
    created() {
      if (this.message) {
        this.flash(this.message);
      }
      
      this.$eventBus.$on(
        'flash', (message,type) => this.flash(message, type)
      );
    },
    methods: {
      flash(message, type) {
          this.body = message;
          this.type = type;
          this.showAlert();
      },
      countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      },
      showAlert() {
        this.dismissCountDown = this.dismissSecs;
      }
    }
  };
</script>