<script setup>
import BaseModal from "@/components/BaseModal.vue";
import DataCount from "@/components/DataCount.vue";
import InputCheckBox from "@/components/InputCheckBox.vue";
import InputSelect from "@/components/InputSelect.vue";
import InputSelectPrefecture from "@/components/InputSelectPrefecture.vue";
import InputText from "@/components/InputText.vue";
import Pagination from "@/components/Pagination.vue";
import SortIcon from "@/components/SortIcon.vue";
import Tooltip from "@/components/Tooltip.vue";
import { store } from "@/store";
import { formatDate } from "@/utils/formatter";
import { computed, onMounted, ref } from "vue";
import router from "../../router";

onMounted(async () => {
  await fetchData();
});
const customers = computed(() => store.getters["customers/data"]);
const meta = computed(() => store.getters["customers/meta"]);
const params = computed(() => store.getters["customers/params"]);
const invalidFeedback = computed(
  () => store.getters["customer/invalidFeedback"]
);
const isInvalid = computed(() => store.getters["customer/isInvalid"]);
const genderFormOptions = computed(
  () => store.getters["consts/genderFormOptions"]
);
const perPageFormOptions = computed(
  () => store.getters["consts/perPageFormOptions"]
);
const avatarUrl = computed(() => store.getters["customer/avatarUrl"]);
const isAdmin = computed(() => store.getters["profile/isAdmin"]);
const searchModalShow = ref(false);
const restoreDialogShow = ref(false);
const tooltipContent = computed(
  () => store.getters["customers/tooltipContent"]
);

const fetchData = async () => {
  await store.dispatch("customers/get", params.value);
};
const resetParams = () => {
  store.commit("customers/resetParams");
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
const search = () => {
  params.value.page = 1;
  fetchData();
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
const moveToCreate = () => {
  router.push("/customers/create");
};
const restore = async (customerId) => {
  await store.dispatch("customer/restore", customerId);
  fetchData();
};
</script>

<template>
  <h2>顧客一覧</h2>
  <div class="d-flex justify-content-end mb-3">
    <button
      type="button"
      class="btn btn-primary"
      title="検索モーダルを開く"
      @click="moveToCreate"
    >
      新規登録
    </button>
  </div>
  <div class="d-flex justify-content-between align-items-end mb-3">
    <DataCount :meta="meta" />
    <div class="col-6 row">
      <div class="col-2">
        <label for="perPage" class="col-form-label">表示件数</label>
      </div>
      <div class="col-2">
        <InputSelect
          id="perPage"
          :options="perPageFormOptions"
          v-model="params.per_page"
          @change="changePerPage"
        />
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <button
        type="button"
        class="btn btn-info me-3"
        title="検索モーダルを開く"
        @click="searchModalShow = true"
      >
        絞り込み検索
      </button>
      <button
        type="button"
        class="btn btn-secondary"
        title="検索条件をリセット"
        @click="resetParams"
      >
        リセット
      </button>
    </div>
  </div>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr class="sticky-top">
        <th
          class="column-name"
          scope="col"
          title="氏名でソート"
          @click="sort('name')"
        >
          氏名
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'name'"
          />
        </th>
        <th scope="col" title="年齢でソート" @click="sort('age')">
          年齢
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'age'"
          />
        </th>
        <th scope="col" title="性別でソート" @click="sort('gender')">
          性別
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'gender'"
          />
        </th>
        <th scope="col" title="電話番号でソート" @click="sort('phone')">
          電話番号
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'phone'"
          />
        </th>
        <th scope="col" title="生年月日でソート" @click="sort('birth_date')">
          生年月日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'birth_date'"
          />
        </th>
        <th scope="col" title="都道府県でソート" @click="sort('pref')">
          都道府県
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'pref'"
          />
        </th>
        <th scope="col" title="登録日でソート" @click="sort('created_at')">
          登録日
          <SortIcon
            :isAsc="params.is_asc"
            :active-sort-key="params.sort_key"
            :label="'created_at'"
          />
        </th>
        <th scope="col" title="更新日でソート" @click="sort('updated_at')">
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
        <td class="align-middle d-flex align-items-center">
          <Tooltip :content="tooltipContent(customer.id)">
            <img
              :src="avatarUrl(customer.avatar)"
              class="avatar me-2"
              loading="lazy"
            />
            <router-link :to="`/customers/` + customer.id"
              >{{ customer.name }}
            </router-link>
          </Tooltip>
          <button
            v-if="customer.deleted_at"
            type="button"
            class="btn btn-secondary ms-2"
            @click="restoreDialogShow = true"
          >
            復元
          </button>
        </td>
        <td class="align-middle">{{ customer.age }}歳</td>
        <td class="align-middle">{{ customer.gender_value }}</td>
        <td class="align-middle">{{ customer.phone }}</td>
        <td class="align-middle">{{ formatDate(customer.birth_date) }}</td>
        <td class="align-middle">{{ customer.pref_value }}</td>
        <td class="align-middle">{{ formatDate(customer.created_at) }}</td>
        <td class="align-middle">{{ formatDate(customer.updated_at) }}</td>
        <BaseModal
          :id="'restoreDialog' + customer.id"
          :class-value="restoreDialogShow === true ? 'show' : ''"
          title="この顧客を復元しますか？"
          button-value="復元する"
          @cancel="restoreDialogShow = false"
          @submit="restore(customer.id)"
        >
        </BaseModal>
      </tr>
    </tbody>
  </table>
  <Pagination :links="meta?.links" @change="changePage" />
  <BaseModal
    id="searchModal"
    :class-value="searchModalShow === true ? 'show' : ''"
    title="絞り込み検索"
    button-value="検索する"
    @cancel="searchModalShow = false"
    @submit="search"
  >
    <form class="row">
      <div>
        <InputCheckBox
          v-if="isAdmin"
          id="searchIsDeleted"
          label="削除済みの顧客"
          v-model="params.search_value.is_deleted"
        />
      </div>
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
        <label for="searchValueGender" class="col-form-label">性別</label>
        <InputSelect
          id="searchValueGender"
          :options="genderFormOptions"
          v-model="params.search_value.gender"
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
  </BaseModal>
</template>
