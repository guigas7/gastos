<template>
  <div>
    teste
  </div>
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
      source: {
        type: Object,
        required: true
      },
    }
  };
</script>