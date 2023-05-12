<script setup>
import Pagination from '@/components/Pagination.vue';
import SortIcon from '@/components/SortIcon.vue';
import { store } from '@/store/index';
import { formatDate } from '@/utils/formatter';
import { computed, onMounted, reactive, ref } from 'vue';

onMounted(async () => {
  await store.dispatch('customers/get', params);
});
const customers = computed(() => store.getters['customers/data']);
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
        <th class="column-name" scope="col" @click="sort('name')">
          氏名
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'name'"
          />
        </th>
        <th scope="col" @click="sort('age')">
          年齢
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'age'"
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
        <th scope="col" @click="sort('created_at')">
          登録日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'created_at'"
          />
        </th>
        <th scope="col" @click="sort('updated_at')">
          更新日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="activeSortKey"
            :label="'updated_at'"
          />
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="customer in customers" :id="customer.ulid">
        <td class="align-middle">
          <img :src="customer.avatar" class="avatar me-2" /><router-link
            :to="`/customers/` + customer.ulid"
            >{{ customer.name }}</router-link
          >
        </td>
        <td class="align-middle">{{ customer.age }}</td>
        <td class="align-middle">{{ customer.gender_value }}</td>
        <td class="align-middle">{{ customer.phone }}</td>
        <td class="align-middle">{{ formatDate(customer.birth_date) }}</td>
        <td class="align-middle">{{ customer.pref_value }}</td>
        <td class="align-middle">{{ formatDate(customer.created_at) }}</td>
        <td class="align-middle">{{ formatDate(customer.updated_at) }}</td>
      </tr>
    </tbody>
  </table>
  <Pagination :links="meta?.links" @change="changePage" />
</template>

<style scoped>
.avatar {
  height: 32px;
  border-radius: 50%;
}
</style>
