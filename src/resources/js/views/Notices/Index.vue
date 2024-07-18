<script setup>
import DataCount from "@/components/DataCount.vue";
import InputSelect from "@/components/InputSelect.vue";
import Pagination from "@/components/Pagination.vue";
import { store } from "@/store";
import { formatDate } from "@/utils/formatter";
import { computed, onMounted, ref } from "vue";

onMounted(async () => {
  await fetchData();
});
const notices = computed(() => store.getters["notices/data"]);
const meta = computed(() => store.getters["notices/meta"]);
const params = computed(() => store.getters["notices/params"]);
const perPageFormOptions = computed(
  () => store.getters["consts/perPageFormOptions"]
);
const loading = computed(() => store.getters["loading/loading"]);
const deleteButtonShow = ref(false);
const isReadClassValue = computed(
  () => store.getters["notices/isReadClassValue"]
);

const fetchData = async () => {
  await store.dispatch("notices/get", params.value);
};
const changePage = (page = null) => {
  if (page) {
    params.value.page = page;
    console.log(params.value.page);
    fetchData();
  }
};
const changePerPage = () => {
  params.value.page = 1;
  fetchData();
};
const resetParams = () => {
  store.commit("notices/resetParams");
  fetchData();
};
const setAllNoticesAsRead = async () => {
  if (!confirm("お知らせをすべて既読にしますか？")) return;
  await store.dispatch("notices/setAllRead");
  await store.dispatch("notices/get");
  await store.dispatch("profile/get");
};
const searchUnreadOnly = () => {
  params.value.page = 1;
  params.value.unread_only = true;
  fetchData();
};
</script>

<template>
  <h2>お知らせ一覧</h2>
  <div class="d-flex justify-content-between align-items-end mb-3">
    <div class="col-3 row">
      <DataCount :meta="meta" />
    </div>
    <div class="col-4 row">
      <div class="col-4">
        <label for="perPage" class="col-form-label">表示件数</label>
      </div>
      <div class="col-6">
        <InputSelect
          id="perPage"
          :options="perPageFormOptions"
          v-model="params.per_page"
          @change="changePerPage"
        />
      </div>
    </div>
    <div class="col-5">
      <button
        type="button"
        class="btn btn-info me-3"
        title="お知らせをすべて既読にする"
        @click="setAllNoticesAsRead"
      >
        すべて既読にする
      </button>
      <button
        type="button"
        class="btn btn-info me-3"
        title="未読のみを表示"
        @click="searchUnreadOnly"
      >
        未読のみを表示
      </button>
      <button
        type="button"
        class="btn btn-secondary"
        title="リセット"
        @click="resetParams"
      >
        リセット
      </button>
    </div>
  </div>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr class="sticky-top">
        <th class="col-7" title="タイトル">タイトル</th>
        <th scope="col-3" title="更新日"></th>
        <th scope="col-2"></th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="notice in notices"
        :id="notice.id"
        @mouseover.self="deleteButtonShow = true"
        @mouseleave.self="deleteButtonShow = false"
        :class="isReadClassValue(notice.is_read)"
      >
        <td class="align-middle">{{ notice.title }}</td>
        <td class="align-middle">{{ formatDate(notice.updated_at) }}</td>
        <td class="align-middle">
          <router-link :to="`/notices/` + notice.id">
            <button type="button" class="btn btn-primary">詳細</button>
          </router-link>
        </td>
      </tr>
    </tbody>
    <div v-if="!notices && !loading">データが存在しません。</div>
  </table>
  <Pagination :links="meta?.links" @change="changePage" />
</template>
