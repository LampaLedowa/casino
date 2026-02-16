"use strict";
(self.webpackChunkbundle = self.webpackChunkbundle || []).push([[9056], {
    49056: (e, t, c) => {
        c.r(t),
        c.d(t, {
            DateWithFullMonth: () => l,
            default: () => o
        });
        var n = c(96540)
          , a = c(96285);
        const r = () => {
            const e = a.c9.now().setLocale("PL").toFormat("LLLL")
              , t = a.c9.now().setLocale("PL").toFormat("Z, TT dd '".concat((e => e.charAt(0).toUpperCase() + e.slice(1))(e), "', yyyy"));
            return "GMT".concat(t)
        }
          , l = () => {
            const [e,t] = (0,
            n.useState)(r());
            return (0,
            n.useEffect)(( () => {
                const e = setInterval(( () => t(r())), 1e3);
                return () => clearInterval(e)
            }
            ), [e]),
            n.createElement("div", null, e)
        }
          , o = l
    }
}]);
//# sourceMappingURL=9056.41a6d18418f635fc4660.chunk.js.map
