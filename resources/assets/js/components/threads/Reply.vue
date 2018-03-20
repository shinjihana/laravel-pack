<template>

</template>
<script>
    export default {
        props : ['attributes'],
        data() {
            return {
                editting    : false,
                body        : this.attributes.body,
            }
        },
        methods : {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body : this.body
                });

                this.editting = false;

                flash('Updated! ');
            }
        }
    }
</script>
<style>

</style>