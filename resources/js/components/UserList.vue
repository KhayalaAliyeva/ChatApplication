<template>
  <div class="col-md-3">
    <div class="users">
      <h5>Users</h5>
      <ul class="list-group list-chat-item">
        <li v-for="user in users" :key="user.id" class="chat-user-list">
          <a :href="userConversationUrl(user.id)">
            <div class="chat-image">
              <div class="chat-image" v-html="makeImageFromName(user.name)"></div>
              <i :class="'fa fa-circle user-status-icon user-icon-' + user.id" title="away"></i>
            </div>
            <div class="chat-name font-weight-bold">{{ user.name }}</div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    users: Array,
  },
  methods: {
    userConversationUrl(userId) {
        return `/conversation/${userId}`;
    },
    makeImageFromName(name) {
      const shortName = name.split(' ').map(namePart => namePart[0]).join('');
      return `<div class="name-image bg-primary">${shortName}</div>`;
    },
  },
};
</script>
