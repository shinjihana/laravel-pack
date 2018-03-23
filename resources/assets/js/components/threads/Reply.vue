<template>
    <div :id="'reply-' + id" class="card mt-2">
        <div class="card-header bg-success">
            <div class="d-flex">
                <div>
                    <a :href="'/profiles/' + data.owner.name" 
                        class="text-white"
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
                <div class="form-group">
                    <label for="edit">Edit</label>
                    <textarea
                        name="edit" id=""
                        rows="3" class="form-control"
                        v-model="body"
                    ></textarea>
                </div>
                <button class="btn btn-primary" @click="update">Update</button>
                <button class="btn btn-xs" @click="editting = false">Cancel</button>
            </div>
            <div v-else="" v-text="body"></div>
        </div>
        <div class="card-footer" v-if="canUpdate">
            <div class="d-flex">
                <button class="btn btn-xs mr-2" @click="editting = true">Edit</button>
                <button class="btn btn-xs btn-danger mr-2" @click="destroy">Delete</button>
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
            }
        },
        computed : {
            ago() {
                return moment(this.data.created_at).fromNow();
            },
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            }
        },
        methods : {
            update() {
                // $("#reply-"+this.attributes.id).fadeOut(200);
                axios.patch('/replies/' + this.data.id, {
                    body : this.body
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
        }
    }
</script>
<style>

</style>