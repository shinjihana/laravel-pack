<script>
    import Replies from '../components/threads/Replies.vue';
    import SubscribeButton from '../components/commons/SubscribeButton.vue';
    export default {
        props : ['initialRepliesCount'],
        components : { Replies, SubscribeButton },
        data (){
            return {
                repliesCount : this.initialRepliesCount,
            }
        }
    }
</script>