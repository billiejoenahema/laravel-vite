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
  ascending: true,
};
const params = reactive({
  ...defaultParams,
  page: 1,
});

const sort = (sortValue) => {
  activeSortKey.value = sortValue;
  if (params.sort_value.includes(sortValue)) {
    params.ascending = !params.ascending;
  } else {
    params.ascending = true;
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
        <th scope="col" @click="sort('name')">
          name
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'name'"
          />
        </th>
        <th scope="col" @click="sort('email')">
          email
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'email'"
          />
        </th>
        <th scope="col" @click="sort('phone')">
          phone
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'phone'"
          />
        </th>
        <th scope="col" @click="sort('birth_date')">
          birth date
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'birth_date'"
          />
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="user in users"
        :id="user.id"
        @click="showDetail(user.id)"
        class="user-row"
      >
        <th>{{ user.name }}</th>
        <td>{{ user.email }}</td>
        <td>{{ user.phone }}</td>
        <td>{{ user.birth_date }}</td>
      </tr>
    </tbody>
  </table>
  <Pagination :links="meta?.links" @change="changePage" />
</template>
