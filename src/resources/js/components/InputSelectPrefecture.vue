<script setup>
const props = defineProps({
  classValue: {
    type: String,
    required: false,
    default: "",
  },
  disabled: {
    default: false,
    required: false,
    type: Boolean,
  },
  id: {
    default: "",
    required: true,
    type: String,
  },
  invalidFeedback: {
    default: "",
    required: false,
    type: String,
  },
  modelValue: {
    default: "",
    required: false,
    type: [String, Number],
  },
});
const emit = defineEmits(["update:modelValue"]);
const updateModelValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>

<template>
  <select
    class="form-select"
    :class="classValue"
    :disabled="disabled"
    :id="id"
    :value="modelValue"
    @change="updateModelValue"
  >
    <optgroup label="北海道・東北">
      <option value="1">北海道</option>
      <option value="2">青森県</option>
      <option value="3">岩手県</option>
      <option value="4">宮城県</option>
      <option value="5">秋田県</option>
      <option value="6">山形県</option>
      <option value="7">福島県</option>
    </optgroup>
    <optgroup label="関東">
      <option value="8">茨城県</option>
      <option value="9">栃木県</option>
      <option value="10">群馬県</option>
      <option value="11">埼玉県</option>
      <option value="12">千葉県</option>
      <option value="13">東京都</option>
      <option value="14">神奈川県</option>
    </optgroup>
    <optgroup label="中部">
      <option value="15">新潟県</option>
      <option value="16">富山県</option>
      <option value="17">石川県</option>
      <option value="18">福井県</option>
      <option value="19">山梨県</option>
      <option value="20">長野県</option>
      <option value="21">岐阜県</option>
      <option value="22">静岡県</option>
      <option value="23">愛知県</option>
    </optgroup>
    <optgroup label="近畿">
      <option value="24">三重県</option>
      <option value="25">滋賀県</option>
      <option value="26">京都府</option>
      <option value="27">大阪府</option>
      <option value="28">兵庫県</option>
      <option value="29">奈良県</option>
      <option value="30">和歌山県</option>
    </optgroup>
    <optgroup label="中国">
      <option value="31">鳥取県</option>
      <option value="32">島根県</option>
      <option value="33">岡山県</option>
      <option value="34">広島県</option>
      <option value="35">山口県</option>
    </optgroup>
    <optgroup label="四国">
      <option value="36">徳島県</option>
      <option value="37">香川県</option>
      <option value="38">愛媛県</option>
      <option value="39">高知県</option>
    </optgroup>
    <optgroup label="九州・沖縄">
      <option value="40">福岡県</option>
      <option value="41">佐賀県</option>
      <option value="42">長崎県</option>
      <option value="43">熊本県</option>
      <option value="44">大分県</option>
      <option value="45">宮崎県</option>
      <option value="46">鹿児島県</option>
      <option value="47">沖縄県</option>
    </optgroup>
  </select>
  <div class="invalid-feedback">{{ invalidFeedback }}</div>
</template>
