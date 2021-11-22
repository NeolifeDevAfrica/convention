<div class="container mt-5" id="app">
    <div class="row">
        <form @submit.prevent="search" class="col-12">
            <input v-model="query" @keyup="search" :disabled="disabled" type="text" ref="input" class="form-control form-contorl-lg text-center order_id" placeholder="Search Tickets by Order ID or Neolife ID">
        </form>
    </div>

    <div class="row">

        <table class="col-12 table table-striped mt-2 col-12" style="font-size:16px; background:#fff; z-index:9999;" id="table">

            <tr v-if="message.length">
                <td colspan="8" class="text-center bg-white text-success order_id">{{message}}</td>
            </tr>

            <tr v-if="error.length">
                <td colspan="8" class="text-center bg-white text-danger order_id">{{error}}</td>
            </tr>

            <tr v-if="not_found">
                <th colspan="8" class="text-center text-white bg-danger order_id">TICKET {{query}} NOT FOUND</th>
            </tr>

            <thead v-if="tickets.length > 0">
                <tr>
                    <th>ORDER ID</th>
                    <th>NEOLIFE ID</th>
                    <th>CUSTOMER NAME</th>
                    <th>TICKET</th>
                    <th>RANK</th>
                    <th>TEAM NAME</th>
                    <th>PT NAME</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody v-for="row in tickets">

                <tr>
                    <td>{{row.order_id}}</td>
                    <td>{{row.neolife_id}}</td>
                    <td>{{row.customer_name}}</td>
                    <td>{{row.item_code}}</td>
                    <td>{{row.rank}}</td>
                    <td>{{row.team_name}}</td>
                    <td>{{row.pt_name}}</td>
                    <td>{{row.status == 1 ? 'PRESENT' : 'ABSENT'}}</td>
                </tr>
                <tr>
                    <th colspan="8" class="text-center">
                        <button type="button" :class="['btn', row.status == 1 ? 'btn-danger' : 'btn-success']" @click="mark(row)">{{row.status == 1 ? 'UNMARK' : 'MARK'}} TICKET</button>
                    </th>
                </tr>

            </tbody>

        </table>

    </div>
</div>