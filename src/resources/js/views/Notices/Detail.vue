<script setup>
import router from "@/router";
import { store } from "@/store";
import { computed, onMounted, reactive } from "vue";

const notice = reactive({
  id: null,
  title: null,
  content: null,
  created_at: null,
  updated_at: null,
  read_at: null,
});
const noticeId = router.currentRoute.value?.params?.id;
const loading = computed(() => store.getters["loading/loading"]);

onMounted(async () => {
  await fetchData();
});

// お知らせ取得
const fetchData = async () => {
  await store.dispatch("notice/get", noticeId);
  Object.assign(notice, store.getters["notice/data"]);
  await store.dispatch("profile/get");
};
</script>

<template>
  <div class="mb-3">
    <router-link to="/notices">一覧に戻る</router-link>
  </div>
  <h2>お知らせ詳細</h2>
  <form v-if="notice.id" class="notice-form">
    <div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="noticeId" class="col-form-label">お知らせID</label>
        </div>
        <div class="col-10">
          <div id="noticeId" class="form-control border-0">
            {{ notice.id }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="noticeTitle" class="col-form-label">タイトル</label>
        </div>
        <div class="col-10">
          {{ notice.title }}
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="noticeTitle" class="col-form-label">内容</label>
        </div>
        <div class="col-10">
          {{ notice.content }}
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="noticeTitle" class="col-form-label">登録日</label>
        </div>
        <div class="col-10">
          {{ notice.created_at }}
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="noticeTitle" class="col-form-label">更新日</label>
        </div>
        <div class="col-10">
          {{ notice.updated_at }}
        </div>
      </div>
    </div>
  </form>
  <div v-if="!notice.id && !loading">データが存在しません。</div>
</template>

<style scoped>
.avatar-container {
  position: relative;
}

.edit-icon {
  position: absolute;
  left: 100px;
  top: 88px;
}

.trash-icon {
  position: absolute;
  left: 100px;
  top: 0;
}
</style>
