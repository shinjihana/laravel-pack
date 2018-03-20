<template>

</template>
<script>
    import Favorite from '../common/Favorite.vue';
    export default {
        props : ['attributes'],
        components : { Favorite },
        data() {
            return {
                editting    : false,
                body        : this.attributes.body,
            }
        },
        methods : {
            update() {
                // $("#reply-"+this.attributes.id).fadeOut(200);
                axios.patch('/replies/' + this.attributes.id, {
                    body : this.body
                });

                this.editting = false;

                flash('Updated! ');
            },
            destroy(){
                axios.delete('/replies/' +  this.attributes.id);
                
                $(this.$el).fadeOut(300, ()=>{
                    flash('Your reply was deleted');
                });
            },
        }
    }
</script>
<style>

</style>