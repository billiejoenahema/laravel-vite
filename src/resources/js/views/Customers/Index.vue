<script setup>
import Pagination from '@/components/Pagination.vue';
import SortIcon from '@/components/SortIcon.vue';
import { reactive, ref } from 'vue';

// onMounted(async () => {
//   await store.dispatch('customers/get', params);
// });
const users = [
  {
    id: 1,
    name: 'user1',
    email: 'user1@example.com',
    phone: '01012345678',
    birth_date: '2000/01/01',
  },
  {
    id: 1,
    name: 'user2',
    email: 'user2@example.com',
    phone: '02012345678',
    birth_date: '2000/02/02',
  },
  {
    id: 1,
    name: 'user3',
    email: 'user3@example.com',
    phone: '03012345678',
    birth_date: '2000/03/03',
  },
];
const links = [
  {
    url: null,
    active: false,
    label: '&laquo; 前',
  },
  {
    url: 'http://localhost:8081/customers?page=1',
    active: true,
    label: '1',
  },
  {
    url: 'http://localhost:8081/customers?page=2',
    active: false,
    label: '2',
  },
  {
    url: 'http://localhost:8081/customers?page=3',
    active: false,
    label: '3',
  },
  {
    url: null,
    active: false,
    label: '次 &raquo;',
  },
];
// const links = computed(() => store.dispatch('customers/links'));
// const meta = computed(() => store.dispatch('customers/meta'));
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
  // store.dispatch('customers/get', params)
};

const showDetail = (id) => {
  console.log({ id });
  // router.push(`/customers/${id}`);
};
const changePage = (page = null) => {
  if (page) {
    params.page = page;
    // store.dispatch('customers/get', params)
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
  <Pagination :links="links" @change="changePage" />
</template>
