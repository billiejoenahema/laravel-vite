<script setup>
import Pagination from '@/components/Pagination.vue';
import SortIcon from '@/components/SortIcon.vue';
import { store } from '@/store/index';
import { computed, onMounted, reactive, ref } from 'vue';

onMounted(async () => {
  await store.dispatch('customers/get', params);
});
const users = computed(() => store.getters['customers/data']);
const meta = computed(() => store.getters['customers/meta']);
const activeSortKey = ref('');

const defaultParams = {
  search_column: '',
  search_value: '',
  sort_value: '',
  is_asc: true,
};
const params = reactive({
  ...defaultParams,
  page: 1,
});

const sort = (sortValue) => {
  activeSortKey.value = sortValue;
  if (params.sort_value.includes(sortValue)) {
    params.is_asc = !params.is_asc;
  } else {
    params.is_asc = true;
    Object.assign(params, { ...defaultParams });
    params.sort_value = sortValue;
  }
  params.page = 1;
  store.dispatch('customers/get', params);
};

const showDetail = (id) => {
  console.log({ id });
  // router.push(`/customers/${id}`);
};
const changePage = (page = null) => {
  if (page) {
    params.page = page;
    store.dispatch('customers/get', params);
  }
};
</script>

<template>
  <h2>顧客一覧</h2>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr class="sticky-top">
        <th class="column-id" scope="col" @click="sort('id')">
          ID
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'id'"
          />
        </th>
        <th class="column-name" scope="col" @click="sort('name')">
          氏名
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'name'"
          />
        </th>
        <th scope="col" @click="sort('gender')">
          性別
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'gender'"
          />
        </th>
        <th scope="col" @click="sort('phone')">
          電話番号
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'phone'"
          />
        </th>
        <th scope="col" @click="sort('birth_date')">
          生年月日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'birth_date'"
          />
        </th>
        <th scope="col" @click="sort('pref')">
          都道府県
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'pref'"
          />
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="user in users" :id="user.id" @click="showDetail(user.id)">
        <th scope="row">{{ user.id }}</th>
        <td>{{ user.name }}</td>
        <td>{{ user.gender }}</td>
        <td>{{ user.phone }}</td>
        <td>{{ user.birth_date }}</td>
        <td>{{ user.pref }}</td>
      </tr>
    </tbody>
  </table>
  <Pagination :links="meta?.links" @change="changePage" />
</template>
