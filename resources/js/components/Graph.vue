<template>
    <div style="height: 400px; width: 400px;">
        <canvas width="400" height="400"></canvas>
    </div>
</template>

<script>
    import {Chart} from 'Chart.js';
    
        export default {
        props: {
            labels: Array,
            values: Array
        },
        methods: {
            renderChart() {
                new Chart(this.$el.firstElementChild.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: this.labels,
                        datasets: [
                          {
                            label: 'Tipo de dado',
                              fillColor: "rgba(100,220,220,0.7)",
                              strokeColor: "rgba(220,220,220,1)",
                              pointColor: "rgba(220,220,220,1)",
                              pointStrokeColor: "#fff",
                              pointHighlightFill: "#fff",
                              pointHighlightStroke: "rgba(220,220,220,1)",
                              data: this.values
                          }
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            fontSize: 22,
                            text: 'Example',
                            responsive: false,

                        }
                    }
                });
            }
        },
        mounted() {
            this.renderChart();
        }
    }
</script>
