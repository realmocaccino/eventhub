export function useFormattedPrice() {
  const formatPrice = (price) => {
    return price ? '$' + Number(price).toFixed(2) : 'Free';
  };

  return { formatPrice };
}