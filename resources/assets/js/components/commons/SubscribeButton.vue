<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>
<script>
    export default {
        props : ['active'],
        data() {
            return {
                isActive : this.active
            }
        },
        computed : {
            classes() {
                return ['btn', this.isActive ? 'btn-warning' : 'btn-default']
            }
        },
        methods : {
            subscribe() {

                axios[ 
                    (this.isActive ? 'delete' : 'post')
                    ](location.pathname + '/subscriptions');

                this.isActive = ! this.isActive;

                flash('Subscribed');
            }
        }
    }
</script>