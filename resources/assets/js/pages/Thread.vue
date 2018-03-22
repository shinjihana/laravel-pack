<script>
    import Replies from '../components/threads/Replies.vue';
    import SubscribeButton from '../components/common/SubscribeButton.vue';
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