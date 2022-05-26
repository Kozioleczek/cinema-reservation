export enum RESERVATION_STEPS {
  IDLE = "idle",
  PICK_PLACE = "pick_place",
  PAYMENT = "payment",
  THANK_YOU = "thank_you",
}

export interface Place {
  column: number;
  row: number;
}

export interface CreditCard {
  number: number;
  cvc: number;
  exp: number;
  name: string;
}

export interface ClientDetails {
  name: string;
  surname: string;
  prefix: number;
  phone: number;
}

export interface ReservationDetails {
  movieID: number | null;
  place: Place | null;
  creditCard: CreditCard | null;
  clientDetails: ClientDetails | null;
}

export interface Movie {
  movieID: number;
  thumbnail: string;
  title: string;
  date: Date;
}
