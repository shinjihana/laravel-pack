<template>
    <div :id="'reply-' + id" class="card mt-2">
        <div class="card-header" :class="isBest ? 'bg-success' : 'bg-default'">
            <div class="d-flex">
                <div>
                    <a :href="'/profiles/' + data.owner.name" 
                        class="text-black"
                        v-text="data.owner.name"
                        >
                    </a>
                    said <span v-text="ago"></span>...
                </div>
                <div class="ml-auto" v-if="signedIn">
                    <div class="d-flex">
                        <div>
                            <favorite :reply="data"></favorite>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editting">
                <form @submit="update">
                    <div class="form-group">
                        <label for="edit">Edit</label>
                        <textarea
                            name="edit"
                            rows="3" class="form-control"
                            v-model="body"
                            required
                        ></textarea>
                    </div>
                    <button class="btn btn-primary">Update</button>
                    <button class="btn btn-xs" @click="editting = false">Cancel</button>
                </form>
            </div>
            <div v-else="" v-html="body"></div>
        </div>
        <div class="card-footer">
            <div class="d-flex">
                <div v-if="authorize('updateReply', reply)">
                    <button class="btn btn-xs mr-2" @click="editting = true">Edit</button>
                    <button class="btn btn-xs btn-danger mr-2" @click="destroy">Delete</button>
                </div>
                <div class="ml-auto">
                    <button class="btn btn-xs btn-primary mr-2"
                        @click="markBestReply"
                        v-show="! isBest"
                    >Best Reply</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Favorite from '../commons/Favorite.vue';
    import moment from 'moment';
    export default {
        props : ['data'],
        components : { Favorite },
        data() {
            return {
                editting    : false,
                body        : this.data.body,
                id : this.data.id,
                reply : this.data,
                thread : window.thread,
            }
        },
        computed : {
            ago() {
                return moment(this.data.created_at).fromNow();
            },
            isBest() {
                return this.thread.best_reply_id == this.id;
            }
        },
        methods : {
            update() {
                // $("#reply-"+this.attributes.id).fadeOut(200);
                axios.patch('/replies/' + this.data.id, {
                    body : this.body
                })
                .catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.editting = false;

                flash('Updated! ');
            },
            destroy(){
                axios.delete('/replies/' +  this.data.id);
                
                this.$emit('deleted', this.data.id);
                // $(this.$el).fadeOut(300, ()=>{
                //     flash('Your reply was deleted');
                // });
            },
            markBestReply() {
                axios.post('/replies/'+ this.data.id + '/best');

                this.thread.best_reply_id = this.id;
            }
        }
    }
</script>
<style>

</style>