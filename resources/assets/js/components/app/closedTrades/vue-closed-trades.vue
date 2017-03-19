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
        <div>
            <table class="table table-inverse" style="margin-bottom: 0;">
                <tbody v-for="(skill, index) in skills">
                <tr>
                    <td style="text-align: left;">{{ skill.close_date }}</td>
                    <td style="text-align: left;">{{ skill.underlier_symbol }}</td>
                    <td style="text-align: right;">{{ skill.profits }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <table class="table table-inverse">
            <tbody v-for="(skill, index) in skills">
            <tr v-if="(index + 1) == skills.length">
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
    export default {
        data(){
            return{
                skills: []
            }
        },
        created() {
            console.log('vue-closed-trades Component is  ready.');

            let self = this;

            axios.get('/api/closedSymbols')
                .then(function (response) {
                    self.skills = response.data;
            });

//            $.ajax({
//                type: "GET",
//                url: '/api/closedSymbols',
//                contentType: "application/json; charset=utf8",
//                dataType: "json",
//                success: function (response) {
//                    console.log(response);
//                    self.skills = response;
//                }
//            });

        },

        computed: {
            runningTotal: function () {
                if (this.skills.length > 0) {
                    return this.skills.reduce(function(prev, elem){
                        return prev + elem.profits;
                    },0);
                } else {
                    return 0;
                }
            }
        }
    }
</script>
