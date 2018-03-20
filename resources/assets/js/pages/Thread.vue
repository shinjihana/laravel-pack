<script>
    import Replies from '../components/threads/Replies.vue';
    export default {
        props : ['initialRepliesCount'],
        components : { Replies },
        data (){
            return {
                repliesCount : this.initialRepliesCount,
            }
        }
    }
</script>