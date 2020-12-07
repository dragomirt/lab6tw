function Currency({ currencies }) {
    return (
        <ul>
            {currencies.map((currency) => (
                <li>{currency.name} | {currency.symbol}</li>
            ))}
        </ul>
    )
}

export async function getStaticProps() {
    const res = await fetch('http://127.0.0.1:8080/api/currency');
    const currencies = await res.json();

    return {
        props: {
            currencies
        }
    }
}

export default Currency