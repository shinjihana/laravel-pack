<script>
    import Replies from '../components/threads/Replies.vue';
    import SubscribeButton from '../components/commons/SubscribeButton.vue';
    export default {
        props : ['thread'],
        components : { Replies, SubscribeButton },
        data (){
            return {
                repliesCount : this.thread.replies_count,
                locked : this.thread.locked
            }
        },
        methods : {
            toggleLock () {
                axios[
                    this.locked ? 'delete' : 'post'
                ]('/locked-threads/' + this.thread.slug);

                this.locked = ! this.locked;
            }
        }
    }
</script>