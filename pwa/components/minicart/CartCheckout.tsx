import CartItem from "./CartItem"
import { useCartStore } from "../../stores/useCartStore"
import useFromStore from "../../hooks/useFromStore"
import { v4 } from "uuid";




function Cart() {
    const cart = useFromStore(useCartStore, state => state.cart)
    const cleanCart = useCartStore(state => state.cleanCart)

    const onPayClick = () => {

      console.log(v4())
    }
    let total = 0
    if (cart) {
        total = cart.reduce((acc, product) => acc + product.price * (product.quantity as number), 0)
    }

    return (
        <section>
            <h3 className='text-2xl font-bold mb-4'>Shopping Cart</h3>
            <ul>
                {cart?.map(product => (
                    <CartItem key={product.id} product={product} />
                ))}
            </ul>
            <div className='flex justify-between items-center mt-4'>
                <span className='text-lg font-bold'>Total:</span>
                <span className='text-xl font-bold'>${total.toFixed(2)}</span>
            </div>
            <button type='button'
                    className='ml-2 bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600'
                    onClick={() => cleanCart()}
					>Pay and Clean</button>
        </section>
    )
}

export default Cart
