<script setup>
import InputSelectPrefecture from '@/components/InputSelectPrefecture.vue';
import InputText from '@/components/InputText.vue';
import Pagination from '@/components/Pagination.vue';
import SortIcon from '@/components/SortIcon.vue';
import { store } from '@/store/index';
import { formatDate } from '@/utils/formatter';
import SearchModal from '@/views/Customers/SearchModal.vue';
import { computed, onMounted, ref } from 'vue';

onMounted(async () => {
  await fetchData();
});
const customers = computed(() => store.getters['customers/data']);
const meta = computed(() => store.getters['customers/meta']);
const params = computed(() => store.getters['customers/params']);
const modalShow = ref(false);
const invalidFeedback = computed(
  () => store.getters['customer/invalidFeedback']
);
const isInvalid = computed(() => store.getters['customer/isInvalid']);

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
  <button
    type="button"
    class="btn btn-info"
    data-bs-toggle="modal"
    data-bs-target="#searchModal"
    @click="modalShow = true"
  >
    絞り込み検索
  </button>
  <SearchModal
    id="searchModal"
    :class-value="modalShow === true ? 'show' : ''"
    @cancel="modalShow = false"
    @submit="fetchData"
  >
    <form class="row">
      <div>
        <label for="searchValueName" class="col-form-label">氏名</label>
        <InputText
          id="searchValueName"
          :class-value="isInvalid('name')"
          :invalid-feedback="invalidFeedback('name')"
          v-model="params.search_value.name"
        />
      </div>
      <div>
        <label for="searchValueNameKana" class="col-form-label">ふりがな</label>
        <InputText
          id="searchValueNameKana"
          :class-value="isInvalid('name_kana')"
          :invalid-feedback="invalidFeedback('name_kana')"
          v-model="params.search_value.name_kana"
        />
      </div>
      <div>
        <label for="searchValuePhone" class="col-form-label">電話番号</label>
        <InputText
          id="searchValuePhone"
          :class-value="isInvalid('phone')"
          :invalid-feedback="invalidFeedback('phone')"
          v-model="params.search_value.phone"
        />
      </div>
      <div>
        <label for="searchValuePostalCode" class="col-form-label"
          >郵便番号</label
        >
        <InputText
          id="searchValuePostalCode"
          :class-value="isInvalid('postal_code')"
          :invalid-feedback="invalidFeedback('postal_code')"
          v-model="params.search_value.postal_code"
        />
      </div>
      <div>
        <label for="searchValuePref" class="col-form-label">都道府県</label>
        <InputSelectPrefecture
          id="searchValuePref"
          v-model="params.search_value.pref"
        />
      </div>
    </form>
  </SearchModal>
  <div class="d-flex justify-content-end mb-3">
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
