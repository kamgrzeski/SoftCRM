<template>
    <v-content>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="charts">
                    <apexchart width="650" type="line" :options="options" :series="series"></apexchart>
                </div>
            </div>
        </div>
    </v-content>
</template>

<script>

    export default {
    components: {
    },
    mounted() {
    },
    created() {
    },
    data: function() {
        return {
            options: {
                colors: ["#FF0000"],
                chart: {
                    id: 'vuechart-example'
                },
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]

                },
            },
            series: [{
                name: 'series-1',
                data: [30, 40, 45, 50, 49, 60, 70, 91]
            }]
        }
    },
    props: [],
    computed: {
        dashboard() {
            return this.$store.state.contentData;
        }
    },
    methods: {
        getLatestTasksChart() {

        }
    }
}
</script>

