<script setup lang="ts">
import { RESERVATION_STEPS, ReservationDetails, Movie, Place } from "./types";
import { useMachine, MachineState } from "./composables/useMachine";

enum ReservationEvents {
  SELECT_MOVIE = "SELECT_MOVIE",
  SELECT_PLACE = "SELECT_PLACE",
  PROCEED_PAYMENT = "PROCEED_PAYMENT",
  GO_TO_PREVIOUS = "GO_TO_PREVIOUS",
}

const initialState: ReservationDetails = {
  movieID: null,
  place: null,
  creditCard: null,
  clientDetails: null,
};

const availableStates: MachineState<ReservationDetails>[] = [
  {
    id: RESERVATION_STEPS.IDLE,
    on: {
      [ReservationEvents.SELECT_MOVIE]: {
        target: RESERVATION_STEPS.PICK_PLACE,
        action: (_, selectedMovieID: string) => {
          return {
            movieID: selectedMovieID,
          };
        },
      },
    },
  },
  {
    id: RESERVATION_STEPS.PICK_PLACE,
    on: {
      [ReservationEvents.SELECT_PLACE]: {
        target: RESERVATION_STEPS.PICK_PLACE,
        action: (_, selectedPlace: Place) => {
          return {
            place: selectedPlace,
          };
        },
      },
      [ReservationEvents.GO_TO_PREVIOUS]: {
        target: RESERVATION_STEPS.IDLE,
        action: () => {
          return {
            movieID: null,
            place: null,
          };
        },
      },
    },
  },
];

const { is, send, context } = useMachine<ReservationDetails>(
  initialState,
  RESERVATION_STEPS.IDLE,
  availableStates
);

const movies: Movie[] = [
  {
    movieID: 1,
    thumbnail: "https://dummyimage.com/300x400/000/fff",
    title: "Cyclist fantasy",
    date: new Date(2022, 5, 26),
  },
  {
    movieID: 2,
    thumbnail: "https://dummyimage.com/300x400/000/fff",
    title: "One cyclist, one bike",
    date: new Date(2022, 5, 27),
  },
  {
    movieID: 3,
    thumbnail: "https://dummyimage.com/300x400/000/fff",
    title: "Horny Biker: Coming out 2",
    date: new Date(2022, 5, 28),
  },
];
</script>

<template>
  <header class="container-xl flex justify-center py-5">
    <p>Cinema Reservation System</p>
  </header>
  <main v-if="is(RESERVATION_STEPS.IDLE)" class="container-xl flex gap-5">
    <div
      v-for="(movie, index) in movies"
      :key="index"
      @click="send(ReservationEvents.SELECT_MOVIE, movie.movieID)"
    >
      <img :src="movie.thumbnail" :alt="`${movie.title} - Thumbnail`" />

      {{ movie.title }}
    </div>
  </main>
  <main v-if="is(RESERVATION_STEPS.PICK_PLACE)" class="container-xl flex gap-5">
    Pick place
    {{ context }}

    <button @click="send(ReservationEvents.GO_TO_PREVIOUS, null)">
      Go back
    </button>
  </main>
</template>
