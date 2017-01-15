
// framework
require('./bootstrap');

// ezSlot
Vue.component('vue-closed-trades', require('./components/app/closedTrades/vue-closed-trades.vue'));

new Vue({
    el: '#portfolio'
});

