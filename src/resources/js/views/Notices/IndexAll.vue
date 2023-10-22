<script setup>
import DataCount from '@/components/DataCount.vue';
import InputSelect from '@/components/InputSelect.vue';
import Pagination from '@/components/Pagination.vue';
import { store } from '@/store';
import { formatDate } from '@/utils/formatter';
import { computed, onMounted, ref } from 'vue';

onMounted(async () => {
  await fetchData();
});
const notices = computed(() => store.getters['notices/data']);
const meta = computed(() => store.getters['notices/meta']);
const params = computed(() => store.getters['notices/params']);
const perPageFormOptions = computed(
  () => store.getters['consts/perPageFormOptions']
);
const deleteButtonShow = ref(false)

const fetchData = async () => {
  await store.dispatch('notices/get', params.value);
};
const changePage = (page = null) => {
  if (page) {
    params.value.page = page;
    fetchData();
  }
};
const changePerPage = () => {
  params.value.page = 1;
  fetchData();
};
</script>

<template>
  <h2>お知らせ一覧</h2>
  <div class="d-flex justify-content-between align-items-end mb-3">
    <DataCount :meta="meta" />
    <div class="col-6 row">
      <div class="col-2">
        <label for="perPage" class="col-form-label">表示件数</label>
      </div>
      <div class="col-3">
        <InputSelect id="perPage" :options="perPageFormOptions" v-model="params.per_page" @change="changePerPage" />
      </div>
    </div>
  </div>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr class="sticky-top">
        <th class="col-6" title="タイトル">
          タイトル
        </th>
        <th scope="col-3" title="更新日">
          更新日
        </th>
        <th scope="col-2"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="notice in notices" :id="notice.id" @mouseover.self="deleteButtonShow = true"
        @mouseleave.self="deleteButtonShow = false">
        <td class="align-middle">{{ notice.title }}</td>
        <td class="align-middle">{{ formatDate(notice.updated_at) }}</td>
        <td class="align-middle">
          <router-link :to="`/notices/` + notice.id">
            <button type="button" class="btn btn-primary">詳細</button>
          </router-link>
        </td>
      </tr>
    </tbody>
  </table>
  <Pagination :links="meta?.links" @change="changePage" />
</template>

