Vue.component('home', {
    props: ['user'],

    mounted() {
        //
    },
    computed: {
        upperName() {
            return this.user.name.toUpperCase();
        }
    }
});
