<script setup>
import Pagination from '@/components/Pagination.vue';
import SortIcon from '@/components/SortIcon.vue';
import { store } from '@/store/index';
import { formatDate } from '@/utils/formatter';
import { computed, onMounted } from 'vue';

onMounted(async () => {
  await fetchData();
});
const customers = computed(() => store.getters['customers/data']);
const meta = computed(() => store.getters['customers/meta']);
const params = computed(() => store.getters['customers/params']);

const fetchData = () => {
  store.dispatch('customers/get', params.value);
};
const resetParams = () => {
  store.commit('customers/resetParams');
  fetchData();
};
const sort = (value) => {
  if (params.value.sort_key === value) {
    params.value.is_asc = !params.value.is_asc;
  } else {
    params.value.is_asc = true;
    params.value.sort_key = value;
  }
  params.value.page = 1;
  fetchData();
};
const changePage = (page = null) => {
  if (page) {
    params.value.page = page;
    fetchData();
  }
};
</script>

<template>
  <h2>顧客一覧</h2>
  <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-secondary" @click="resetParams">
      リセット
    </button>
  </div>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr class="sticky-top">
        <th class="column-name" scope="col" @click="sort('name')">
          氏名
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'name'"
          />
        </th>
        <th scope="col" @click="sort('age')">
          年齢
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'age'"
          />
        </th>
        <th scope="col" @click="sort('gender')">
          性別
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'gender'"
          />
        </th>
        <th scope="col" @click="sort('phone')">
          電話番号
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'phone'"
          />
        </th>
        <th scope="col" @click="sort('birth_date')">
          生年月日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'birth_date'"
          />
        </th>
        <th scope="col" @click="sort('pref')">
          都道府県
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'pref'"
          />
        </th>
        <th scope="col" @click="sort('created_at')">
          登録日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'created_at'"
          />
        </th>
        <th scope="col" @click="sort('updated_at')">
          更新日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'updated_at'"
          />
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="customer in customers" :id="customer.id">
        <td class="align-middle">
          <img :src="customer.avatar" class="avatar me-2" /><router-link
            :to="`/customers/` + customer.id"
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
