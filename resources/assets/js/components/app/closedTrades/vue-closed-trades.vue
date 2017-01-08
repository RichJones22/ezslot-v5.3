<template>
    <div class="row">
        <table class="table table-inverse" style="margin-bottom: 0;">
            <thead>
            <tr>
                <th>Trade Date</th>
                <th>Symbol</th>
                <th style="text-align: right;">Profits</th>
            </tr>
            </thead>
        </table>
        <div style="max-height: 800px; overflow: auto;">
            <table class="table table-inverse" style="margin-bottom: 0;">
                <tbody v-for="(itemObjKey, skill) in skills">
                <tr>
                    <td style="text-align: left;">{{ skill.close_date }}</td>
                    <td style="text-align: left;">{{ skill.underlier_symbol }}</td>
                    <td style="text-align: right;">{{ skill.profits }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <table class="table table-inverse">
            <tbody v-for="(itemObjKey, skill) in skills">
            <tr v-if="(itemObjKey + 1) == skills.length">
                <td class="col-xs-8"></td>
                <td class="col-xs-2">Total:</td>
                <td class="col-xs-2">{{ runningTotal }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</template>
<style>
    /* remove borders from table */
    .table tbody+tbody {
        border: none;
    }

    .table th, .table td {
        font-family: Courier, Menlo, Monaco, Consolas, "Courier New", monospace;
    }

</style>
<script>
    export default{
        ready() {
            console.log('vue-closed-trades Component ready.');

            let outerThis = this;

            Event.$on('symbol-passed', function(selected){
                let myStr =  "/bySymbol/";
                myStr = myStr.concat(selected);
                outerThis.getSymbol(myStr);
            });
        },
        methods: {
            getSymbol: function(url) {
                axios.get(url).then(response => this.skills = response.data);
            }
        },
        data(){
            return{
                skills: {}
            }
        },
        computed: {
            runningTotal: function () {
                return this.skills.reduce(function(prev, elem){
                    return prev + elem.profits;
                },0);
            }
        }
    }
</script>
