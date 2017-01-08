<template>
    <div>
        <select v-model="selected" @change="passSymbol( selected )" class="form-control col-xs-12 select-bg">
            <option v-for="option in options" v-bind:value="option.value">
                {{ option.text }}
            </option>
        </select>
    </div>
</template>
<style>

    /* set the background color of the drop down box*/
    .select-bg {
        background-color: #cdcdcd;
    }

    /* set background when selected */
    .select-bg:focus, .select-bg[type]:focus {
        background-color: #cdcdcd;
    }

</style>
<script>
    export default{
        ready() {
            console.log('select-symbol Component ready.');

            axios.get('/api/symbolsUnique').then(response => this.options = response.data);
        },
        data(){
            return{
                selected: 'ANF',
                options: {}
            }
        },
        methods: {
            passSymbol: function() {
                Event.$emit('symbol-passed', this.selected)
            }
        }
    }
</script>