<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

let form = ref([]);
const router = useRouter();

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

onMounted(async () => {
    getInvoice();
});

const getInvoice = async () => {
    await axios.get(`/api/invoices/${props.id}`).then((response) => {
        form.value = response.data.data;
    });
};

const goHome = () => {
    router.push(`/`);
};

const print = () => {
    window.print();
    router.push("/").catch(() => {});
};

const onEdit = (id) => {
    router.push(`/edit/${id}`);
};

const onDelete = (id) => {
    if (confirm("Do you really want to delete?")) {
        if (id != undefined) {
            axios.delete(`/api/invoices/${id}`).then(() => {
                goHome();
            });
        }
    }
};
</script>
<template>
    <div class="container">
        <div class="invoices">
            <div class="card__header">
                <div>
                    <a href="#" @click="goHome">
                        <h2 class="invoice__title">Invoice</h2>
                    </a>
                </div>
                <div></div>
            </div>
            <div>
                <div class="card__header--title">
                    <h1 class="mr-2">#{{ form.id }}</h1>
                    <p>{{ form.created_at }}</p>
                </div>

                <div>
                    <ul class="card__header-list">
                        <li>
                            <!-- Select Btn Option -->
                            <button class="selectBtnFlat" @click="print">
                                <i class="fas fa-print"></i>
                                Print
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                        <li>
                            <!-- Select Btn Option -->
                            <button
                                class="selectBtnFlat"
                                @click="onEdit(form.id)"
                            >
                                <i class="fas fa-reply"></i>
                                Edit
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                        <li>
                            <!-- Select Btn Option -->
                            <button
                                class="selectBtnFlat"
                                @click="onDelete(form.id)"
                            >
                                <i class="fas fa-pencil-alt"></i>
                                Delete
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table invoice">
                <div class="logo">
                    <img
                        src="assets/img/logo.png"
                        alt=""
                        style="width: 200px"
                    />
                </div>
                <div class="invoice__header--title">
                    <p></p>
                    <p class="invoice__header--title-1">Invoice</p>
                    <p></p>
                </div>

                <div class="invoice__header--item">
                    <div>
                        <h2>Invoice To:</h2>
                        <p v-if="form.customer">
                            {{ form.customer.fullname }}
                        </p>
                    </div>
                    <div>
                        <div class="invoice__header--item1">
                            <p>Invoice#</p>
                            <span>#{{ form.number }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Date</p>
                            <span>{{ form.date }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Due Date</p>
                            <span>{{ form.due_date }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Reference</p>
                            <span>{{ form.reference }}</span>
                        </div>
                    </div>
                </div>

                <div class="table py1">
                    <div class="table--heading3">
                        <p>#</p>
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Qty</p>
                        <p>Total</p>
                    </div>

                    <!-- item 1 -->
                    <div
                        class="table--items3"
                        v-for="(item, i) in form.items"
                        :key="item.id"
                    >
                        <p>{{ i + 1 }}</p>
                        <p v-if="item.product">
                            {{ item.product.description }}
                        </p>
                        <p v-else>-</p>
                        <p>$ {{ item.unit_price }}</p>
                        <p>{{ item.quantity }}</p>
                        <p>$ {{ item.unit_price * item.quantity }}</p>
                    </div>
                </div>

                <div class="invoice__subtotal">
                    <div>
                        <h2>Thank you for your business</h2>
                    </div>
                    <div>
                        <div class="invoice__subtotal--item1">
                            <p>Sub Total</p>
                            <span> $ {{ form.sub_total }}</span>
                        </div>
                        <div class="invoice__subtotal--item2">
                            <p>Discount</p>
                            <span>{{ form.discount }} %</span>
                        </div>
                    </div>
                </div>

                <div class="invoice__total">
                    <div>
                        <h2>Terms and Conditions</h2>
                        <p>
                            {{ form.terms_and_conditions }}
                        </p>
                    </div>
                    <div>
                        <div class="grand__total">
                            <div class="grand__total--items">
                                <p>Grand Total</p>
                                <span>$ {{ form.total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
