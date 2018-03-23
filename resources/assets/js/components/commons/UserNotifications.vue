<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a id="notificationDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <span>{{iconBell}}</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
            <div v-for="notification in notifications">
                <a class="dropdown-item" 
                    :href="notification.data.link" v-text="notification.data.message"
                    @click="markAsRead(notification)"></a>
            </div>
        </div>
    </li>
</template>
<script>
    import icons from 'glyphicons';
    export default {
        data() {
            return {
                notifications : false,
                iconBell : icons.bell,
            }
        }, 
        created() {
            axios.get("/profiles/"+ window.App.user.name + "/notifications")
                  .then(response => this.notifications = response.data);
        },
        methods : {
            markAsRead(notification) {
                axios.delete("/profiles/" + window.App.user.name + "/notifications/" + notification.id);
            }
        }
    }
</script>