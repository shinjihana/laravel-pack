<template>
    <div>
        <div class="card mt-2" v-if="signedIn">
            <div class="card-body">
                    <div class="form-group">
                        <label for="body">コメント : </label>
                        <textarea 
                            required
                            name="body" id="" 
                            placeholder="コメントを入力してください。"
                            class="form-control" cols="30" rows="5"
                            v-model="body"
                            required
                            >
                        </textarea>
                    </div>
                    <button type="submit"
                            class="btn btn-defaul"
                            @click="addReply"
                            >Submit</button>
            </div>
        </div>

        <div class="card-header text-center bg-secondary text-white mt-3" v-else>
            <a href="/login" class="text-white">コメントできるため、ログインしてください</a>
        </div>
    </div>

</template>
<script>
    import 'at.js';
    export default {
        data(){
            return {
                body : '',
                endpoint : location.pathname + '/replies',
            }
        },
        computed : {
            signedIn(){
                return window.App.signedIn;
            }
        },
        mounted(){
            $('#body').atwho({
                at : "@",
                delay : 790,
                callbacks : {
                    remoteFilter : function(query, callback){
                        console.log('called');
                        // $.getJSON("/users.php", {q : query}, function(username) {
                        //     callback(username);
                        // });
                    }
                }
            });
        },
        methods : {
            addReply (){
                axios.post(this.endpoint, { body : this.body})
                     .catch(error => {
                        flash(error.response.data, 'danger');
                     })
                     .then(({data}) => {
                         this.body = '';

                         flash('Your reply has been posted.');

                         this.$emit('created', data);
                     });
            }
        }
    }
</script>