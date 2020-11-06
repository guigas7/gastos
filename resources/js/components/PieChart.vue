<template>
    <div>
        <canvas width="200" height="200"></canvas>
    </div>
</template>

<script>
    import {Chart} from 'Chart.js';
    
        export default {
        props: {
            groups: Array,
            anualSums: Array,
            colors: Array
        },
        methods: {
            renderChart(data) {
                new Chart(this.$el.firstElementChild.getContext('2d'), data);
            }
        },
        computed: {
              values () {
                    return this.anualSums.map(x => x.toFixed(2));
              }
        },
        mounted() {
            this.renderChart({
                type: 'pie',
                data: {
                    datasets: [{
                        label: this.groups,
                        backgroundColor: this.colors,
                        data: this.values
                    }],
                    labels: this.groups
                },
                options: {
                    title: {
                        display: true,
                        responsive: false,
                        text: 'Despesa Anual',
                        fontSize: 22
                    },
                    tooltips: {
                        callbacks: {
                            // this callback is used to create the tooltip label
                            label: function(tooltipItem, data) {
                                // get the data label and data value to display
                                // convert the data value to local string so it uses a comma seperated number
                                var dataLabel = data.labels[tooltipItem.index];
                                var value = ': ' + Number(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index])
                                    .toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
                                // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
                                if (Chart.helpers.isArray(dataLabel)) {
                                    // show value on first line of multiline label
                                    // need to clone because we are changing the value
                                    dataLabel = dataLabel.slice();
                                    dataLabel[0] += value;
                                } else {
                                    dataLabel += value;
                                }
                                // return the text to display on the tooltip
                                return dataLabel;
                                }
                        }
                    }
                }
            });
        }
    }
</script>

toFixed(2);
