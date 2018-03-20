<template>
    <button type="submit" @click="toggle" :class="classes">
            <span class="glyphicon glyphicon-heart">{{ heartIcon }}</span>
            <span v-text="count"></span>
    </button>
</template>
<script>
    import icons from 'glyphicons'
    export default {
        props : ['reply'],
        data(){
            return {
                count           : this.reply.favoritesCount,
                active          : this.reply.isFavorited,
                heartIcon       : icons.heart
            }
        },
        computed : {
            classes(){
                return ['btn', this.active ? 'btn-primary': 'btn-default']
            },
            endpoint(){
                return '/replies/' + this.reply.id + '/favorites';
            }
        },
        created(){
            //initializing anything
        },
        methods : {
            toggle(){
                this.active ? this.destroy() : this.create();
            },
            destroy(){
                axios.delete(this.endpoint); //created the endpoint
                this.active = false;
                this.count--;
            },
            create(){
                axios.post(this.endpoint); //created the endpoint
                this.active = true;
                this.count++;
            }
        }
    }
</script>