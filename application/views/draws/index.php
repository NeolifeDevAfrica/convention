<div class="container mt-5" id="app">

  <div class="row">

    <div class="col-12">

      <p class='text-center' style="font-size:25px;" v-if="!complete && !status">
        You have <strong>{{tickets.length}}</strong> Tickets to choose from based on your filter. <code class="text-danger">(<a href="javasacript:;" @click="view_tickets" class="text-danger">View Them</a>)</code>
      </p>

      <div class="form-group" v-if="!complete && !status">
        <label>How Many Winners are there for this Draw?</label>
        <div class="input-group mb-3">
          <input type="number" v-model="winners_count" class="form-control form-control-lg" placeholder="Enter number of Winners here">
          <div class="input-group-append">
            <span class="input-group-text btn btn-primary" @click="draw" id="basic-addon2">Start Draw</span>
          </div>
        </div>

      </div>

      <h1 class="display-4 text-center" v-if="current_name.length > 0">{{current_name}}</h1>

      <table class="table table-bordered" v-if="winners.length > 0">

        <tbody>
          <tr v-for="row in winners" class="bg-success">
            <td>
              <h4 class='text-white text-bold'>WINNER!</h4>
            </td>
            <td>
              <h4 class='text-white text-bold'>{{row.neolife_id}} ({{row.order_id}})</h4>
            </td>
            <td>
              <h4 class='text-white text-bold'>{{row.customer_name}}</h4>
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered table-striped" v-if="show_tickets">

        <thead>
          <tr>
            <th>Neolife ID</th>
            <th>Rank</th>
            <th>Ticket</th>
            <th>July PPV</th>
            <th>July P.S</th>
            <th>August PPV</th>
            <th>August P.S</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in tickets">
            <td>{{row.neolife_id}}<br><small>{{row.customer_name}}</small></td>
            <td>{{row.rank_description}}</td>
            <td>{{row.item_code}}</td>
            <td>{{row.july_ppv}}</td>
            <td>{{row.july_personal_sponsoring}}</td>
            <td>{{row.august_ppv}}</td>
            <td>{{row.august_personal_sponsoring}}</td>
          </tr>
        </tbody>
      </table>

    </div>

  </div>
</div>

<script src="<?=base_url('assets/js/vue.js') ?>"></script>

<script type="text/javascript">

  let filters = JSON.parse('<?=json_encode($filters) ?>');

  var app = new Vue({

    el: '#app',

    data: {

      tickets: [],
      filters: filters,
      show_tickets: false,
      winners_count: '',
      current_name: '',
      current_id: 0,
      winners: [],
      status: false,
      complete: false

    },

    created(){

      try{

        fetch('<?=site_url('draws/filter') ?>', {method: 'POST', body: JSON.stringify(this.filters)})
        .then(resp => resp.json())
        .then(data => {

          this.tickets = data.tickets;

        })

      }catch(ex){

        console.log(ex)
        window.location = '<?=site_url('draws/form') ?>'
      }
    },
    methods: {

      view_tickets(){

        this.show_tickets = !this.show_tickets;
      },

      random(min = 1, max = 100){

        return Math.floor(Math.random()*(max-min+1)+min);

      },

      draw(){

        try{

          if(this.tickets.length < 1)
            return alert('No tickets avaliable to run draw against. Please check your filter and try again.');

          if(this.winners_count < 1)
            return alert('Please input the number of winners you want for this Draw.');

          this.status = true;
          this.show_tickets = false;
          this.current_name = '';
          this.current_id = '';

          let interval = setInterval(() => {

            let current = this.tickets[this.random(0, this.tickets.length -1)];
            this.current_name = current.customer_name;
            this.current_id = current.id;

          }, 100);

          setTimeout(() => {

            clearInterval(interval);

            this.tickets.forEach(row => {

              let duplicate = false;

              if(row.id == this.current_id){

                this.winners.forEach(row => {

                  if(row.id == this.current_id)
                    duplicate = true;
                });

                if(duplicate == false)
                  this.winners = [...this.winners, row];
              }

            });

            if(this.winners.length != parseInt(this.winners_count))
              this.draw();

            if(this.winners.length == parseInt(this.winners_count)){

              this.status = false;
              this.complete = true;
              this.current = null;
              this.current_name = '';
              this.current_id = 0;
            }

          }, 1000 * this.random(3, 6));

        }catch(ex){

          console.log(ex.message);
          alert('Reload this page and try again!');

        }

      }
    }
  });
</script>