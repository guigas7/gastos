<template>
    <div class="card-body">
        <div class="cent">
            <div class="d.flex row p-0">
                <ul class="col-6 align-self-start">
                    <div v-for="(type, index) in leftTypes">
                        <show-type
                            :source-slug="sourceSlug"
                            :type-attrs="type"
                            :base-url="baseUrl"
                            :initial-recs="type.records"
                            :c-color="cColor"
                            :month="month"
                            :year="year">
                        </show-type>
                    </div>
                </ul>
                <ul class="col-6 align-self-start">
                    <div v-for="(type, index) in rightTypes">
                        <show-type
                            :source-slug="sourceSlug"
                            :type-attrs="type"
                            :base-url="baseUrl"
                            :initial-recs="type.records"
                            :c-color="cColor"
                            :month="month"
                            :year="year">
                        </show-type>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    props: {
      inTypes: {
        types: Array,
        required: true,
      },
      baseUrl: {
        type: String,
        required: true,
      },
      cColor: {
        type: String,
        required: false
      },
      month: {
        type: String,
        required: false
      },
      year: {
        type: String,
        required: false
      },
      sourceSlug: {
        type: String,
        required: false
      }
    },
    computed: {
      leftTypes: function () {
        return this.inTypes.filter((type, index) => (index % 2 === 0 ? true : false));
      },
      rightTypes: function () {
        return this.inTypes.filter((type, index) => (index % 2 === 1 ? true : false));
      }
    }
  };
</script>