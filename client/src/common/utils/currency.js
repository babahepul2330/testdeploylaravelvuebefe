export function parseCurrency(jumlah) {
  return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(jumlah)
}

export function parseCurrencyWithUnits(number) {
  let formattedNumber;
  let suffix = '';

  if (number >= 1_000_000_000) {
    formattedNumber = number / 1_000_000_000;
    suffix = 'B';
  } else if (number >= 1_000_000) {
    formattedNumber = number / 1_000_000;
    suffix = 'M';
  } else if (number >= 1_000) {
    formattedNumber = number / 1_000;
    suffix = 'K';
  } else {
    formattedNumber = number;
  }

  const formatter = new Intl.NumberFormat("id-ID", {
    style: 'currency',
    currency: "IDR",
    minimumFractionDigits: 2
  });

  return formatter.format(formattedNumber) + suffix;
}