<template>
    <div>
        <div class="d-flex">
            <div class="mr-2">
                <img :src="avatar" width="200" height="200">
            </div>
            <div>
                <h4 v-text="user.name"></h4>
                <form
                    v-if="canUpdate" 
                    method="POST"
                    enctype="multipart/form-data">
                    <image-upload name="avatar" @loaded="onLoad"></image-upload>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import ImageUpload from './ImageUpload.vue';
    export default {
        props : ['user'],
        components : { ImageUpload },
        data (){
            return {
                avatar : null,
            }
        },
        created (){
            this.avatar = this.user.avatar_path;
        },
        computed : {
            canUpdate() {
                return this.authorize(user => user.id == this.user.id)
            }
        }, 
        methods : {
            onLoad (avatar) {
                console.log(avatar);
                this.avatar = avatar.src;

                this.persist(avatar.file);
            },
            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);
                axios.post('/api/users/${this.user.name}/avatar', data)
                     .then(() => flash('Avatar uploaded'));
            }
        }
    }
</script>