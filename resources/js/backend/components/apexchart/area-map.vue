<template>
    <div class="xl:col-span-3 lg:col-span-6 order-1">
        <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">
            <div class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
                <h6 class="text-lg font-semibold">Area Map</h6>

                <span class="text-slate-400">Last update 5 days ago</span>
            </div>

            <div class="p-6">
                <apexchart type="polarArea" height="270" :options="chartOptions" :series="series"></apexchart>
            </div>
        </div>
    </div>

</template>

<script>
import ApexCharts from 'vue3-apexcharts'

export default {
    data() {
        return {
            series: [12468, 14168, 15468, 17468],
            chartOptions: {
                chart: {
                    height: 270,
                    type: 'polarArea'
                },
                labels: ['Canada', 'Russia', 'Greenland', 'Palestine'],
                fill: {
                    opacity: 1
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']

                },
                colors: ['#86efac', '#22c55e', '#16a34a', '#15803d'],
                yaxis: {
                    show: false,
                },
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    polarArea: {
                        rings: {
                            strokeWidth: 0
                        },
                        spokes: {
                            strokeWidth: 0
                        },
                    }
                },
            }
        }
    },
    components: {
        apexchart: ApexCharts
    },
}
</script>

<style lang="scss" scoped>

</style>